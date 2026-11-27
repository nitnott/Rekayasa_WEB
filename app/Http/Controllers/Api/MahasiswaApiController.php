<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Mahasiswa::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|unique:mahasiswas,nim',
            'nama' => 'required|max:100',
            'jk' => 'required|in:L,P',
            'prodi' => 'required|max:100',
            'no_telp' => 'required|max:20',
            'alamat' => 'required'
        ]);

        $mahasiswa = Mahasiswa::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data mahasiswa berhasil ditambahkan',
            'data' => $mahasiswa
        ], 201);
    }

    public function update(Request $request, $nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);

        $validated = $request->validate([
            'nama' => 'required|max:100',
            'jk' => 'required|in:L,P',
            'prodi' => 'required|max:100',
            'no_telp' => 'required|max:20',
            'alamat' => 'required'
        ]);

        $mahasiswa->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data mahasiswa berhasil diperbarui',
            'data' => $mahasiswa
        ]);
    }

    public function destroy($nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);

        $mahasiswa->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data mahasiswa berhasil dihapus'
        ]);
    }
}
