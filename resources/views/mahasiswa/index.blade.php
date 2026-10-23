
@extends('layouts.main')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="mahasiswa-page">

    <div class="mahasiswa-header">
        <div>
            <span class="mahasiswa-label">DATA AKADEMIK</span>
            <h2>Data Mahasiswa</h2>
            <p>Kelola informasi mahasiswa dengan mudah.</p>
        </div>

        <a href="{{ route('mahasiswa.create') }}" class="btn-tambah">
            <span>+</span> Tambah Mahasiswa
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <span>✓</span> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            Data gagal diproses. Periksa kembali formulir kamu.
        </div>
    @endif

    <div class="mahasiswa-info">
        <div class="info-icon">M</div>
        <div>
            <strong>Daftar Mahasiswa</strong>
            <p>Total {{ $data->count() }} mahasiswa terdaftar</p>
        </div>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Jenis Kelamin</th>
                    <th>Program Studi</th>
                    <th>No. Telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($data as $item)
                    <tr>
                        <td class="nomor">{{ $loop->iteration }}</td>
                        <td>
                            <span class="nim-badge">{{ $item->nim }}</span>
                        </td>
                        <td class="nama-mahasiswa">{{ $item->nama }}</td>
                        <td>
                            {{ $item->jk == 'L' ? 'Laki-laki' : ($item->jk == 'P' ? 'Perempuan' : $item->jk) }}
                        </td>
                        <td>{{ $item->prodi }}</td>
                        <td>{{ $item->no_telp }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>
                            <div class="aksi-mahasiswa">
                                <a href="{{ route('mahasiswa.edit', $item->nim) }}"
                                   class="btn-edit">
                                    Edit
                                </a>

                                <form action="{{ route('mahasiswa.destroy', $item->nim) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus data mahasiswa ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-hapus">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty-data">
                            <div class="empty-icon">📋</div>
                            <strong>Belum ada data mahasiswa</strong>
                            <p>Tambahkan data mahasiswa untuk mulai mengelola daftar.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <span>Menampilkan {{ $data->count() }} data mahasiswa</span>
        <span>PT Teknologi Nusantara</span>
    </div>

</div>
@endsection
