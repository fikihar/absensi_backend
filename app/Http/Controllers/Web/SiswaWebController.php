<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiswaWebController extends Controller
{
    public function index()
    {
        return view('siswa.dashboard');
    }

    // === Absensi ===
    public function absensiIndex()
    {
        return view('siswa.absensi');
    }

    public function absensiStore(Request $request)
    {
        // Logic untuk menyimpan absensi siswa
    }

    public function create()
    {
        return view('siswa.absensi_create');
    }
}

