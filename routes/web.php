<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Control;

Route::get('/logout', [Control::class, 'logout']);
Route::get('/login', [Control::class, 'Login'])->name('login');
Route::post('/aksi_login', [Control::class, 'aksi_login']);

Route::get('/register', [Control::class, 'register']);
Route::post('/register', [Control::class, 'aksi_register']);

Route::get('/home', [Control::class, 'home']);

Route::get('/profil', [Control::class, 'profil'])
    ->middleware('CheckMenuPermission:profil')
    ->name('profil');
Route::post('/profile/update', [Control::class, 'updateProfil']);

Route::get('/paket_data', [Control::class, 'paketData'])
    ->middleware('CheckMenuPermission:paket_data')
    ->name('paket.data');
Route::get('/paket_data/filter', [Control::class, 'filterPaket'])
    ->middleware('CheckMenuPermission:paket_data')
    ->name('paket.filter');

Route::get('/tambah-pulsa', [Control::class, 'tambah_pulsa'])->name('tambah_pulsa');
Route::post('/beli-pulsa', [Control::class, 'beliPulsa'])->name('beli_pulsa');

Route::get('/payment/{id_pulsa}', [Control::class, 'showPayment'])->name('payment');
Route::post('/process-payment', [Control::class, 'processPayment'])->name('process.payment');
Route::post('/payment-qris', [Control::class, 'createQrisPayment'])->name('payment.qris.create');
Route::get('/payment-qris/{orderId}', [Control::class, 'showQrisPayment'])->name('payment.qris.show');
Route::get('/payment-qris/{orderId}/status', [Control::class, 'qrisPaymentStatus'])->name('payment.qris.status');
Route::post('/midtrans/finish', [Control::class, 'midtransFinish'])->name('midtrans.finish');

Route::get('/payment-kuota/{id_kuota}', [Control::class, 'showKuotaPayment'])->name('payment.kuota');
Route::post('/process-kuota-purchase', [Control::class, 'processPurchaseKuota'])->name('process.kuota.purchase');
Route::post('/midtrans/notification', [Control::class, 'midtransNotification'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
    ->name('midtrans.notification');

Route::get('/riwayat-transaksi', [Control::class, 'riwayatTransaksi'])
    ->middleware('CheckMenuPermission:data_transaksi')
    ->name('riwayat.transaksi');

Route::get('/laporan-penjualan', [Control::class, 'laporanPenjualan'])
    ->name('laporan.penjualan');

Route::get('/statistik-produk', [Control::class, 'statistikProduk'])
    ->name('statistik.produk');

Route::get('/level1-transactions', [Control::class, 'level1Transactions'])
    ->middleware('CheckMenuPermission:data_transaksi')
    ->name('level1.transactions');

Route::get('/data-user', [Control::class, 'dataUser'])
    ->middleware('CheckMenuPermission:data_user')
    ->name('data.user');

Route::get('/data-admin', [Control::class, 'dataAdmin'])
    ->middleware('CheckMenuPermission:data_admin')
    ->name('data.admin');

Route::middleware(['auth.session'])->group(function () {
    // Hak akses (hanya superadmin)
    Route::get('/hak-akses', [Control::class, 'hakAkses'])->name('hak_akses');
    Route::post('/hak-akses/update', [Control::class, 'updateHakAkses'])->name('hak_akses.update');
});