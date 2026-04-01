<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Control;
Route::get('/logout', [Control::class, 'logout']);
Route::get('/login', [Control::class, 'Login'])->name('login');
Route::post('/aksi_login', [Control::class, 'aksi_login']);

Route::get('/register', [Control::class, 'register']);
Route::post('/register', [Control::class, 'aksi_register']);

Route::get('/home', [Control::class, 'home']);
Route::get('/tambah_pulsa', [Control::class, 'tambah_pulsa']);

Route::get('/profil', [Control::class, 'profil'])->name('profil');
Route::post('/profile/update', [Control::class, 'updateProfil']);