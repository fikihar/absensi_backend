<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminWebController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    // === Manajemen Siswa ===
    public function siswaIndex()
    {
        return view('admin.data_siswa');
    }

    public function siswaStore(Request $request)
    {
        // Logic simpan siswa
    }

    public function siswaUpdate(Request $request, $id)
    {
        // Logic update siswa
    }

    public function siswaDestroy($id)
    {
        // Logic hapus siswa
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

