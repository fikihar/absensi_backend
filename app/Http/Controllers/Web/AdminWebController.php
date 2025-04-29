<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Dudi;
use App\Models\Absensi;


class AdminWebController extends Controller
{
    public function index()
    {
        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalDudi = Dudi::count();
        $totalAbsensi = Absensi::count();

        return view('admin.dashboard', compact('totalSiswa', 'totalGuru', 'totalDudi', 'totalAbsensi'));
    }

    // === Manajemen Siswa ===
    public function siswaIndex()
    {
        // Mengambil semua data siswa
        $siswas = Siswa::all();

        // Mengirim data ke view
        return view('admin.data_siswa', compact('siswas'));
    }


    public function siswaStore(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'user_id' => 'required|exists:users,id',  // Pastikan user_id valid (berkaitan dengan tabel users)
            'nis' => 'required|string|unique:siswas,nis',
            'nama' => 'required|string|max:100',
            'kelas' => 'required|string|max:10',
        ]);

        // Simpan data siswa
        Siswa::create([
            'user_id' => $request->user_id,  // User ID untuk relasi dengan tabel users
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function siswaUpdate(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        // Validasi data update
        $request->validate([
            'user_id' => 'required|exists:users,id',  // Pastikan user_id valid (berkaitan dengan tabel users)
            'nis' => 'required|string|unique:siswas,nis,' . $id,
            'nama' => 'required|string|max:100',
            'kelas' => 'required|string|max:10',
        ]);

        // Update data siswa
        $siswa->update([
            'user_id' => $request->user_id,
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }



    public function siswaDestroy($id)
{
    $siswa = Siswa::findOrFail($id);
    $siswa->delete();

    return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus!');
}


    // === Manajemen Guru ===
    public function guruIndex()
    {
        return view('admin.data_guru');
    }

    public function guruStore(Request $request)
    {
        // Logic simpan guru
    }

    public function guruUpdate(Request $request, $id)
    {
        // Logic update guru
    }

    public function guruDestroy($id)
    {
        // Logic hapus guru
    }

    // === Manajemen DUDI ===
    public function dudiIndex()
    {
        return view('admin.data_dudi');
    }

    public function dudiStore(Request $request)
    {
        // Logic simpan dudi
    }

    public function dudiUpdate(Request $request, $id)
    {
        // Logic update dudi
    }

    public function dudiDestroy($id)
    {
        // Logic hapus dudi
    }

    // === Alokasi Siswa ke DUDI ===
    public function alokasiSiswaIndex()
    {
        return view('admin.alokasi_siswa');
    }

    public function alokasiSiswaStore(Request $request)
    {
        // Logic alokasi siswa
    }

    public function alokasiSiswaDestroy($id)
    {
        // Logic hapus alokasi siswa
    }

    // === Alokasi Guru ke DUDI ===
    public function alokasiGuruIndex()
    {
        return view('admin.alokasi_guru');
    }

    public function alokasiGuruStore(Request $request)
    {
        // Logic alokasi guru
    }

    public function alokasiGuruDestroy($id)
    {
        // Logic hapus alokasi guru
    }

    // === Laporan Absensi ===
    public function laporanAbsensi()
    {
        return view('admin.laporan_absensi');
    }

    public function exportAbsensiPdf()
    {
        // Logic export PDF
    }
}
