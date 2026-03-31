<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Pulsa;
use Illuminate\Support\Facades\Auth;
class Control extends Controller
{
public function Login()
{
    $num1 = rand(1,9);
    $num2 = rand(1,9);

    session([
        'num1' => $num1,
        'num2' => $num2
    ]);

    return view('login');
}

public function aksi_login(Request $request)
{
    // ========================
    // VALIDASI CAPTCHA
    // ========================
    if ($request->captcha != (session('num1') + session('num2'))) {
        return back()->with('error', 'Captcha salah!');
    }

    // ========================
    // CARI USER
    // ========================
    $user = DB::table('users')
        ->where('no_hp_user', $request->no_hp_user)
        ->first();

    if ($user) {

        // ========================
        // SIMPAN SESSION
        // ========================
        session([
            'id_user' => $user->id_user,
            'name' => $user->nama,
            'no_hp_user' => $user->no_hp_user,
            'level' => $user->level
        ]);

        return redirect('/home');
    }

    return back()->with('error', 'No HP tidak terdaftar!');
}
public function register()
{
    $num1 = rand(1,9);
    $num2 = rand(1,9);

    session([
        'num1' => $num1,
        'num2' => $num2
    ]);

    return view('register');
}

public function aksi_register(Request $request)
{
    // cek captcha
    if ($request->captcha != (session('num1') + session('num2'))) {
        return back()->with('error', 'Captcha salah!');
    }

    // validasi sederhana
    $request->validate([
        'name' => 'required',
        'phone' => 'required|unique:users,no_hp_user',
    ]);

    // simpan data
    Pulsa::create([
        'name' => $request->name,
        'no_hp_user' => $request->phone,
        'level' => 1,
        'total_pulsa' => 0
    ]);

    return redirect('/home')->with('success', 'Register berhasil!');
}

public function home()
{
    if (!session('id_user')) {
        return redirect('/login');
    }

    return view('home', [
        'user' => (object)[
            'id_user' => session('id_user'),
            'name' => session('name'),
            'no_hp_user' => session('no_hp_user'),
            'level' => session('level'),
            'total_pulsa' => session('total_pulsa', 0)
        ]
    ]);
}
}
