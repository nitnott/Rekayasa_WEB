<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
    public function index()
    {
        $data = Mahasiswa::all();

        return view('mahasiswa.index', compact('data'));
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => [
                'required',
                'regex:/^[0-9]+$/',
                'max:15',
                'unique:mahasiswas,nim',
            ],
            'nama' => 'required',
            'jk' => 'required',
            'prodi' => 'required',
            'no_telp' => [
                'required',
                'regex:/^[0-9]+$/',
            ],
            'alamat' => 'required',
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.regex' => 'NIM must be number.',
            'nim.max' => 'NIM maksimal 15 angka.',
            'nim.unique' => 'NIM sudah digunakan.',
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'no_telp.regex' => 'Phone number must be number.',
        ]);

        Mahasiswa::create($request->only([
            'nim',
            'nama',
            'jk',
            'prodi',
            'no_telp',
            'alamat'
        ]));

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);

        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, $nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);

        $request->validate([
            'nim' => [
                'required',
                'regex:/^[0-9]+$/',
                'max:15',
                Rule::unique('mahasiswas', 'nim')
                    ->ignore($mahasiswa->nim, 'nim'),
            ],
            'nama' => 'required',
            'jk' => 'required',
            'prodi' => 'required',
            'no_telp' => [
                'required',
                'regex:/^[0-9]+$/',
            ],
            'alamat' => 'required',
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.regex' => 'NIM must be number.',
            'nim.max' => 'NIM maksimal 15 angka.',
            'nim.unique' => 'NIM sudah digunakan.',
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'no_telp.regex' => 'Phone number must be number.',
        ]);

        $mahasiswa->update($request->only([
            'nim',
            'nama',
            'jk',
            'prodi',
            'no_telp',
            'alamat'
        ]));

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);

        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}