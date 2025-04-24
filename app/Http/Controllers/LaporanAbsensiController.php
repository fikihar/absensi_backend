<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\AlokasiGuru;
use App\Models\AlokasiSiswa;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LaporanAbsensiController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->input('periode', 'harian');
        $tanggal = $request->input('tanggal', '2025-04-19');
        $kelas = $request->input('kelas', 'TJKT A');

        $user = Auth::user();
        $validatedTanggal = Carbon::parse($tanggal);

        if ($periode === 'harian') {
            $startDate = $validatedTanggal->copy()->startOfDay();
            $endDate = $validatedTanggal->copy()->endOfDay();
        } elseif ($periode === 'mingguan') {
            $startDate = $validatedTanggal->copy()->startOfWeek();
            $endDate = $validatedTanggal->copy()->endOfWeek();
        } else {
            $startDate = $validatedTanggal->copy()->startOfMonth();
            $endDate = $validatedTanggal->copy()->endOfMonth();
        }

        $query = Absensi::query()->with(['siswa.user']);

        if ($user->role === 'guru') {
            $guru = $user->guru;
            if (!$guru) {
                abort(403, 'User is not a guru');
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

        if (!empty($kelas)) {
            $siswaIdsByKelas = \App\Models\Siswa::where('kelas', $kelas)->pluck('id');
            $query->whereIn('siswa_id', $siswaIdsByKelas);
        }

        $absensi = $query->get();
        $tanggal_mulai = $startDate->toDateString();
        $tanggal_selesai = $endDate->toDateString();

        $statistik = [
            'total_absensi' => $absensi->count(),
            'total_hadir' => $absensi->where('status', 'Hadir')->count(),
            'total_tidak_hadir' => $absensi->where('status', 'Tidak Hadir')->count(),
        ];

        return view('laporan-absensi', compact('absensi', 'statistik', 'periode', 'tanggal', 'kelas', 'tanggal_mulai', 'tanggal_selesai'));
    }
}
