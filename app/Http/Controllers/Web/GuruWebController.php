<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class GuruWebController extends Controller
{
    public function index()
    {
        return view('guru.dashboard');
    }

    public function absensiIndex()
    {
        return view('guru.absensi');
    }

    public function siswaIndex()
    {
        return view('guru.siswa');
    }

    public function laporanAbsensi()
    {
        return view('guru.laporan_absensi');
    }

    public function exportAbsensiPdf()
    {
        // logic export PDF
    }
}
