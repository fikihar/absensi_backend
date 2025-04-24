<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\AlokasiGuru;
use App\Models\AlokasiSiswa;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;


class AbsensiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'jurnal' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        $lat = $request->latitude;
        $lon = $request->longitude;

        // Jika bukan numeric, coba geocoding
        if (!is_numeric($lat) || !is_numeric($lon)) {
            $locationName = $lat . ' ' . $lon;
            $geoResponse = Http::withHeaders([
                'User-Agent' => 'AbseninWalisongo/1.0'
            ])->get('https://nominatim.openstreetmap.org/search', [
                'q' => $locationName,
                'format' => 'json',
                'limit' => 1
            ]);

            if ($geoResponse->successful() && isset($geoResponse[0]['lat'], $geoResponse[0]['lon'])) {
                $lat = $geoResponse[0]['lat'];
                $lon = $geoResponse[0]['lon'];
            } else {
                return response()->json([
                    'message' => 'Lokasi tidak ditemukan berdasarkan nama yang diberikan.'
                ], 422);
            }
        }

        if (!is_numeric($lat) || !is_numeric($lon)) {
            return response()->json([
                'message' => 'Latitude dan Longitude harus berupa angka atau lokasi yang valid.'
            ], 422);
        }

        $fotoPath = $request->file('foto')->store('absensi', 'public');

        $response = Http::withHeaders([
            'User-Agent' => 'AbseninWalisongo/1.0'
        ])->get('https://nominatim.openstreetmap.org/reverse', [
            'lat' => $lat,
            'lon' => $lon,
            'format' => 'json',
        ]);

        $lokasi = $response->json()['display_name'] ?? 'Unknown Location';

        $absensi = Absensi::create([
            'siswa_id' => $request->user()->siswa->id,
            'foto' => $fotoPath,
            'latitude' => $lat,
            'longitude' => $lon,
            'lokasi' => $lokasi,
            'jurnal' => $request->jurnal,
            'tanggal' => $request->tanggal,
        ]);

        return response()->json([
            'message' => 'Absensi berhasil disimpan',
            'absensi' => $absensi
        ], 201);
    }

    public function index(Request $request)
    {
        $absensi = Absensi::where('siswa_id', $request->user()->siswa->id)->get();
        return response()->json($absensi, 200);
    }

    public function indexAdminGuru(Request $request)
    {
        $user = $request->user();

        // Cek role admin/guru
        if (!$user || !in_array($user->role, ['admin', 'guru'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($user->role === 'admin') {
            // Admin: Ambil semua absensi
            $absensi = Absensi::with(['siswa.user'])->get();
        } else {
            // Guru: Ambil absensi berdasarkan siswa yang dialokasikan ke guru tersebut
            $guru = $user->guru;

            if (!$guru) {
                return response()->json([
                    'message' => 'Data guru tidak ditemukan. Pastikan akun ini telah didaftarkan sebagai guru.'
                ], 403);
            }

            $dudiIds = AlokasiGuru::where('guru_id', $guru->id)->pluck('dudi_id');
            $siswaIds = AlokasiSiswa::whereIn('dudi_id', $dudiIds)->pluck('siswa_id');

            $absensi = Absensi::whereIn('siswa_id', $siswaIds)->with(['siswa.user'])->get();
        }

        return response()->json($absensi, 200);
    }

    public function listSiswa(Request $request)
    {
        $user = $request->user();

        if (!$user || !in_array($user->role, ['admin', 'guru'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($user->role === 'admin') {
            $siswa = Siswa::with(['user'])->get();
        } else {
            $guru = $user->guru;

            if (!$guru) {
                return response()->json([
                    'message' => 'Data guru tidak ditemukan. Pastikan akun ini telah didaftarkan sebagai guru.'
                ], 403);
            }

            $dudiIds = AlokasiGuru::where('guru_id', $guru->id)->pluck('dudi_id');
            $siswa = Siswa::whereIn('id', function ($query) use ($dudiIds) {
                $query->select('siswa_id')
                    ->from('alokasi_siswa')
                    ->whereIn('dudi_id', $dudiIds);
            })->with(['user'])->get();
        }

        return response()->json($siswa, 200);
    }

    public function laporanAbsensi(Request $request)
    {
        $user = $request->user();
        Log::info('LaporanAbsensi: User - ' . ($user ? json_encode($user) : 'No user'));

        // Validasi input
        $validated = $request->validate([
            'periode' => 'required|in:harian,mingguan,bulanan',
            'tanggal' => 'required|date',
            'dudi_id' => 'nullable|exists:dudi,id',
            'siswa_id' => 'nullable|exists:siswa,id',
            'status' => 'nullable|in:Hadir,Tidak Hadir',
            'kelas' => 'nullable|in:TJKT A,TJKT B', // Filter kelas
        ]);

        // Tentukan rentang tanggal berdasarkan periode
        $tanggal = Carbon::parse($validated['tanggal']);
        if ($validated['periode'] === 'harian') {
            $startDate = $tanggal->copy()->startOfDay();
            $endDate = $tanggal->copy()->endOfDay();
        } elseif ($validated['periode'] === 'mingguan') {
            $startDate = $tanggal->copy()->startOfWeek();
            $endDate = $tanggal->copy()->endOfWeek();
        } else { // bulanan
            $startDate = $tanggal->copy()->startOfMonth();
            $endDate = $tanggal->copy()->endOfMonth();
        }

        // Ambil data siswa yang relevan
        $query = Absensi::query()->with(['siswa.user']);

        if ($user->role === 'guru') {
            $guru = $user->guru;
            if (!$guru) {
                return response()->json(['message' => 'User is not a guru'], 403);
            }

            $dudiIds = AlokasiGuru::where('guru_id', $guru->id)
                ->where('tanggal_mulai', '<=', $endDate)
                ->where(function ($query) use ($startDate) {
                    $query->where('tanggal_selesai', '>=', $startDate)
                        ->orWhereNull('tanggal_selesai');
                })
                ->pluck('dudi_id');

            $siswaIds = AlokasiSiswa::whereIn('dudi_id', $dudiIds)
                ->where('tanggal_mulai', '<=', $endDate)
                ->where(function ($query) use ($startDate) {
                    $query->where('tanggal_selesai', '>=', $startDate)
                        ->orWhereNull('tanggal_selesai');
                })
                ->pluck('siswa_id');

            $query->whereIn('siswa_id', $siswaIds);
        }

        // Filter berdasarkan input
        $query->whereBetween('tanggal', [$startDate, $endDate]);

        if (!empty($validated['dudi_id'])) {
            $siswaIdsByDudi = AlokasiSiswa::where('dudi_id', $validated['dudi_id'])->pluck('siswa_id');
            $query->whereIn('siswa_id', $siswaIdsByDudi);
        }

        if (!empty($validated['siswa_id'])) {
            $query->where('siswa_id', $validated['siswa_id']);
        }

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        if (!empty($validated['kelas'])) {
            $siswaIdsByKelas = Siswa::where('kelas', $validated['kelas'])->pluck('id');
            $query->whereIn('siswa_id', $siswaIdsByKelas);
        }

        // Ambil data absensi
        $absensi = $query->get();

        // Hitung statistik
        $totalAbsensi = $absensi->count();
        $totalHadir = $absensi->where('status', 'Hadir')->count();
        $totalTidakHadir = $absensi->where('status', 'Tidak Hadir')->count();

        return response()->json([
            'periode' => $validated['periode'],
            'tanggal_mulai' => $startDate->toDateString(),
            'tanggal_selesai' => $endDate->toDateString(),
            'statistik' => [
                'total_absensi' => $totalAbsensi,
                'total_hadir' => $totalHadir,
                'total_tidak_hadir' => $totalTidakHadir,
            ],
            'data' => $absensi,
        ], 200);
    }

    public function exportPDF(Request $request)
    {
        $user = $request->user();
        Log::info('ExportPDF: User - ' . ($user ? json_encode($user) : 'No user'));

        // Validasi input (sama seperti laporanAbsensi)
        $validated = $request->validate([
            'periode' => 'required|in:harian,mingguan,bulanan',
            'tanggal' => 'required|date',
            'dudi_id' => 'nullable|exists:dudi,id',
            'siswa_id' => 'nullable|exists:siswa,id',
            'status' => 'nullable|in:Hadir,Tidak Hadir',
            'kelas' => 'nullable|in:TJKT A,TJKT B',
        ]);

        // Tentukan rentang tanggal berdasarkan periode
        $tanggal = Carbon::parse($validated['tanggal']);
        if ($validated['periode'] === 'harian') {
            $startDate = $tanggal->copy()->startOfDay();
            $endDate = $tanggal->copy()->endOfDay();
        } elseif ($validated['periode'] === 'mingguan') {
            $startDate = $tanggal->copy()->startOfWeek();
            $endDate = $tanggal->copy()->endOfWeek();
        } else {
            $startDate = $tanggal->copy()->startOfMonth();
            $endDate = $tanggal->copy()->endOfMonth();
        }

        // Ambil data absensi (logika sama seperti laporanAbsensi)
        $query = Absensi::query()->with(['siswa.user']);

        if ($user->role === 'guru') {
            $guru = $user->guru;
            if (!$guru) {
                return response()->json(['message' => 'User is not a guru'], 403);
            }

            $dudiIds = AlokasiGuru::where('guru_id', $guru->id)
                ->where('tanggal_mulai', '<=', $endDate)
                ->where(function ($query) use ($startDate) {
                    $query->where('tanggal_selesai', '>=', $startDate)
                        ->orWhereNull('tanggal_selesai');
                })
                ->pluck('dudi_id');

            $siswaIds = AlokasiSiswa::whereIn('dudi_id', $dudiIds)
                ->where('tanggal_mulai', '<=', $endDate)
                ->where(function ($query) use ($startDate) {
                    $query->where('tanggal_selesai', '>=', $startDate)
                        ->orWhereNull('tanggal_selesai');
                })
                ->pluck('siswa_id');

            $query->whereIn('siswa_id', $siswaIds);
        }

        $query->whereBetween('tanggal', [$startDate, $endDate]);

        if (!empty($validated['dudi_id'])) {
            $siswaIdsByDudi = AlokasiSiswa::where('dudi_id', $validated['dudi_id'])->pluck('siswa_id');
            $query->whereIn('siswa_id', $siswaIdsByDudi);
        }

        if (!empty($validated['siswa_id'])) {
            $query->where('siswa_id', $validated['siswa_id']);
        }

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        if (!empty($validated['kelas'])) {
            $siswaIdsByKelas = Siswa::where('kelas', $validated['kelas'])->pluck('id');
            $query->whereIn('siswa_id', $siswaIdsByKelas);
        }

        $absensi = $query->get();

        // Hitung statistik
        $totalAbsensi = $absensi->count();
        $totalHadir = $absensi->where('status', 'Hadir')->count();
        $totalTidakHadir = $absensi->where('status', 'Tidak Hadir')->count();

        // Siapkan data untuk view PDF
        $data = [
            'periode' => $validated['periode'],
            'tanggal_mulai' => $startDate->toDateString(),
            'tanggal_selesai' => $endDate->toDateString(),
            'statistik' => [
                'total_absensi' => $totalAbsensi,
                'total_hadir' => $totalHadir,
                'total_tidak_hadir' => $totalTidakHadir,
            ],
            'absensi' => $absensi,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('pdf.laporan_absensi', $data);
        return $pdf->download('laporan-absensi-' . $validated['periode'] . '-' . $validated['tanggal'] . '.pdf');
    }
}
