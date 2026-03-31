<?php
<<<<<<< HEAD

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
=======
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Control;

Route::get('/login', [Control::class, 'Login'])->name('login');
Route::post('/aksi_login', [Control::class, 'aksi_login']);

Route::get('/register', [Control::class, 'register']);
Route::post('/register', [Control::class, 'aksi_register']);

Route::get('/home', [Control::class, 'home']);
>>>>>>> 87a5583 (fafa)
