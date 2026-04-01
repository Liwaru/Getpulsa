<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Control extends Controller
{
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function Login()
    {
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);

        session([
            'num1' => $num1,
            'num2' => $num2
        ]);

        return view('login');
    }

    public function aksi_login(Request $request)
    {
        // VALIDASI CAPTCHA
        if ($request->captcha != (session('num1') + session('num2'))) {
            return back()->with('error', 'Captcha salah!');
        }

        // CARI USER
        $user = DB::table('users')
            ->where('no_hp_user', $request->no_hp_user)
            ->first();

        if ($user) {
            // SIMPAN SESSION (termasuk total_pulsa & total_kuota)
            session([
                'id_user'    => $user->id_user,
                'name'       => $user->nama,
                'no_hp_user' => $user->no_hp_user,
                'level'      => $user->level,
                'total_pulsa'=> $user->total_pulsa ?? 0,
                'total_kuota'=> $user->total_kuota ?? 0
            ]);

            return redirect('/home');
        }

        return back()->with('error', 'No HP tidak terdaftar!');
    }

    public function register()
    {
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);

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
            'name'  => 'required',
            'phone' => 'required|unique:users,no_hp_user',
        ]);

        // simpan data
        User::create([
            'name'        => $request->name,
            'email'       => $request->phone . '@temp.local',
            'password'    => bcrypt('password'),
            'no_hp_user'  => $request->phone,
            'level'       => 1,
            'total_pulsa' => 0,
            'total_kuota' => 0
        ]);

        return redirect('/login')->with('success', 'Register berhasil! Silakan login.');
    }

public function home()
{
    if (!session('id_user')) {
        return redirect('/login');
    }

    // Ambil hanya produk dengan id 5 dan 6
    $produk = DB::table('produk')
        ->whereIn('id_produk', [5, 6])
        ->select('id_produk', 'nama_produk', 'masa_aktif', 'harga')
        ->orderBy('id_produk', 'asc')
        ->get();

    return view('home', [
        'user'   => (object)[
            'id_user'     => session('id_user'),
            'name'        => session('name'),
            'no_hp_user'  => session('no_hp_user'),
            'level'       => session('level'),
            'total_pulsa' => session('total_pulsa', 0),
            'total_kuota' => session('total_kuota', 0)
        ],
        'produk' => $produk
    ]);
}

public function beliKuota(Request $request, $id_produk)
{
    $user = DB::table('users')->where('id_user', session('id_user'))->first();
    $produk = DB::table('produk')->where('id_produk', $id_produk)->first();

    // cek saldo pulsa cukup
    if ($user->total_pulsa < $produk->harga) {
        return back()->with('error', 'Saldo pulsa tidak cukup!');
    }

    DB::transaction(function() use ($user, $produk) {
        $sisa_kuota = $user->total_kuota + $produk->jumlah_kuota;

        // update user
        DB::table('users')->where('id_user', $user->id_user)->update([
            'total_pulsa' => $user->total_pulsa - $produk->harga,
            'total_kuota' => $sisa_kuota
        ]);

        // simpan kuota awal di session untuk tampilan
        session([
            'total_pulsa' => $user->total_pulsa - $produk->harga,
            'total_kuota' => $sisa_kuota,
            'kuota_awal'  => $produk->jumlah_kuota
        ]);

        // simpan transaksi
        DB::table('transaksi')->insert([
            'user_id'    => $user->id_user,
            'produk_id'  => $produk->id_produk,
            'harga'      => $produk->harga,
            'kuota_didapat' => $produk->jumlah_kuota,
            'status'     => 'success',
            'created_at' => now()
        ]);
    });

    return back()->with('success', 'Pembelian berhasil!');
}

public function tambah_pulsa()
{
    if (!session('id_user')) {
        return redirect('/login');
    }

    // Anda bisa mengirim data lain yang diperlukan, misalnya daftar nominal pulsa
    // Untuk sementara kita hanya mengembalikan view
    return view('tambah_pulsa');
}
}