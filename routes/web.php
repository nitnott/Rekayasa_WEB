<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\MahasiswaApiController;

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

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth'])->group(function () {

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

    // ROUTE AJAX MAHASISWA

    Route::get('/api/mahasiswa', [MahasiswaApiController::class, 'index']);

    Route::post('/api/mahasiswa', [MahasiswaApiController::class, 'store']);

    Route::put('/api/mahasiswa/{nim}', [MahasiswaApiController::class, 'update']);

    Route::delete('/api/mahasiswa/{nim}', [MahasiswaApiController::class, 'destroy']);

    Route::get('/mahasiswa-ajax', function () {
        return view('mahasiswa.ajax');
    })->name('mahasiswa.ajax');

});
