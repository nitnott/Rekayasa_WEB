@extends('layouts.main')
@section('title', 'Tambah Mahasiswa')
@section('content')

<div class="container">
    <h2>Tambah Data Mahasiswa</h2>

    @include('mahasiswa.form', [
        'mahasiswa' => null,
        'mode' => 'create'
    ])
</div>
@endsection
