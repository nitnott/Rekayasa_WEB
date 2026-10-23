<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;

Route::get('/home', function () {
    return view('page.home');
});

Route::get('/profile', function () {
    return view('page.profile');
});

Route::get('/about', function () {
    return view('page.about');
});

Route::get('/contact', function () {
    return view('page.contact');
});

Route::get('/service', function () {
    return view('page.service');
});

Route::get('/mahasiswa', [MahasiswaController::class, 'index'])
    ->name('mahasiswa.index');

Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])
    ->name('mahasiswa.create');

Route::post('/mahasiswa', [MahasiswaController::class, 'store'])
    ->name('mahasiswa.store');

Route::get('/mahasiswa/{nim}/edit', [MahasiswaController::class, 'edit'])
    ->name('mahasiswa.edit');

Route::put('/mahasiswa/{nim}', [MahasiswaController::class, 'update'])
    ->name('mahasiswa.update');

Route::delete('/mahasiswa/{nim}', [MahasiswaController::class, 'destroy'])
    ->name('mahasiswa.destroy');
