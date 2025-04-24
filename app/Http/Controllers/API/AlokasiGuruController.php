<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AlokasiGuru;
use App\Models\Guru;
use App\Models\Dudi;
use Illuminate\Http\Request;

class AlokasiGuruController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'dudi_id' => 'required|exists:dudi,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        $alokasi = AlokasiGuru::create($request->only([
            'guru_id', 'dudi_id', 'tanggal_mulai', 'tanggal_selesai'
        ]));

        return response()->json(['message' => 'Guru allocated to DUDI', 'alokasi' => $alokasi], 201);
    }

    public function index()
    {
        $alokasi = AlokasiGuru::with(['guru.user', 'dudi'])->get();
        return response()->json($alokasi, 200);
    }

    public function destroy($id)
    {
        $alokasi = AlokasiGuru::findOrFail($id);
        $alokasi->delete();
        return response()->json(['message' => 'Alokasi removed'], 200);
    }
}
