
@extends('layouts.main')

@section('title', 'Edit Mahasiswa')

@section('content')
<div class="container">
    <h2>Edit Data Mahasiswa</h2>

    @include('mahasiswa.form', [
        'mahasiswa' => $mahasiswa,
        'mode' => 'edit'
    ])
</div>
@endsection
