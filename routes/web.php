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

Route::get('/paket_data', [Control::class, 'paketData'])->name('paket.data');
Route::get('/paket_data/filter', [Control::class, 'filterPaket'])->name('paket.filter');

Route::get('/tambah-pulsa', [Control::class, 'tambah_pulsa'])->name('tambah_pulsa');
Route::post('/beli-pulsa', [Control::class, 'beliPulsa'])->name('beli_pulsa');

Route::get('/payment/{id_pulsa}', [Control::class, 'showPayment'])->name('payment');
Route::post('/process-payment', [Control::class, 'processPayment'])->name('process.payment');

Route::get('/payment-kuota/{id_kuota}', [Control::class, 'showKuotaPayment'])->name('payment.kuota');
Route::post('/process-kuota-purchase', [Control::class, 'processPurchaseKuota'])->name('process.kuota.purchase');
Route::get('/riwayat-transaksi', [Control::class, 'riwayatTransaksi'])->name('riwayat.transaksi');

Route::get('/admin/riwayat-transaksi', [Control::class, 'riwayatAdmin'])->name('admin.riwayat');