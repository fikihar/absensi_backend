<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Dudi;
use Illuminate\Http\Request;

class DudiController extends Controller
{
    public function index()
    {
        $dudi = Dudi::all();
        return response()->json($dudi, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'kontak' => 'nullable|string',
        ]);

        $dudi = Dudi::create($request->only(['nama', 'alamat', 'kontak']));
        return response()->json(['message' => 'DUDI created', 'dudi' => $dudi], 201);
    }

    public function update(Request $request, $id)
    {
        $dudi = Dudi::findOrFail($id);
        $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'kontak' => 'nullable|string',
        ]);

        $dudi->update($request->only(['nama', 'alamat', 'kontak']));
        return response()->json(['message' => 'DUDI updated', 'dudi' => $dudi], 200);
    }

    public function destroy($id)
    {
        $dudi = Dudi::findOrFail($id);
        $dudi->delete();
        return response()->json(['message' => 'DUDI deleted'], 200);
    }
}
