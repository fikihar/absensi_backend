<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AlokasiSiswa;
use App\Models\Siswa;
use App\Models\Dudi;
use Illuminate\Http\Request;

class AlokasiSiswaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'dudi_id' => 'required|exists:dudi,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        $alokasi = AlokasiSiswa::create($request->only([
            'siswa_id', 'dudi_id', 'tanggal_mulai', 'tanggal_selesai'
        ]));

        return response()->json(['message' => 'Siswa allocated to DUDI', 'alokasi' => $alokasi], 201);
    }

    public function index()
    {
        $alokasi = AlokasiSiswa::with(['siswa.user', 'dudi'])->get();
        return response()->json($alokasi, 200);
    }

    public function destroy($id)
    {
        $alokasi = AlokasiSiswa::findOrFail($id);
        $alokasi->delete();
        return response()->json(['message' => 'Alokasi removed'], 200);
    }
}
