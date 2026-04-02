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
                'nama'       => $user->nama,
                'no_hp_user' => $user->no_hp_user,
                'level'      => $user->level,
                'total_pulsa'=> $user->total_pulsa ?? 0,
                'total_kuota'=> $user->total_kuota ?? 0
            ]);

            // FLASH MESSAGE SELAMAT DATANG
            session()->flash('welcome', 'Selamat datang, ' . $user->nama);

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
            'nama'  => 'required',
            'phone' => 'required|unique:users,no_hp_user',
        ]);

        // simpan data
        User::create([
            'nama'        => $request->nama,
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

        $user = DB::table('users')
            ->where('id_user', session('id_user'))
            ->first();

        if (!$user) {
            session()->flush();
            return redirect('/login')->with('error', 'User tidak ditemukan.');
        }

        session([
            'nama'        => $user->nama,
            'no_hp_user'  => $user->no_hp_user,
            'level'       => $user->level,
            'total_pulsa' => $user->total_pulsa ?? 0,
            'total_kuota' => $user->total_kuota ?? 0,
        ]);

        $kuota = DB::table('kuota')
            ->whereIn('id_kuota', [5, 6])
            ->select('id_kuota', 'kuota', 'masa_berlaku', 'harga')
            ->orderBy('id_kuota', 'asc')
            ->get();

        return view('home', [
            'user'   => $user,
            'kuota' => $kuota
        ]);
    }

public function tambah_pulsa()
{
    if (!session('id_user')) {
        return redirect('/login');
    }

    $no_hp_user = session('no_hp_user');
    $user = DB::table('users')->where('id_user', session('id_user'))->first();

    // Ambil data pulsa dari tabel pulsa
    $pulsaList = DB::table('pulsa')->orderBy('pulsa', 'asc')->get();

    return view('tambah_pulsa', compact('no_hp_user', 'user', 'pulsaList'));
}    public function profil()
    {
        if (!session('id_user')) {
            return redirect('/login');
        }

        $user = DB::table('users')->where('id_user', session('id_user'))->first();

        return view('profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        if (!session('id_user')) {
            return redirect('/login');
        }

        $userId = session('id_user');

        $request->validate([
            'nama'     => 'required|string|max:255',
        ]);

        $updateData = [
            'nama'       => $request->nama,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        DB::table('users')->where('id_user', $userId)->update($updateData);

        $updatedUser = DB::table('users')->where('id_user', $userId)->first();
        session([
            'nama'       => $updatedUser->nama,
        ]);

        return redirect('/home')->with('success', 'Profil berhasil diperbarui.');
    }

public function paketData()
    {
        if (!session('id_user')) {
            return redirect('/login');
        }

        // Ambil semua kuota, diurutkan dari harga termurah ke termahal
        $kuota = DB::table('kuota')
            ->orderBy('harga', 'asc')
            ->get();

        return view('paket_data', [
            'no_hp' => session('no_hp_user'),
            'kuota' => $kuota
        ]);
    }

    // Endpoint filter via AJAX
    public function filterPaket(Request $request)
    {
        $query = DB::table('kuota');

        // Filter Harga (sesuai opsi baru)
        if ($request->has('harga') && $request->harga != '') {
            switch ($request->harga) {
                case '<15000':
                    $query->where('harga', '<', 15000);
                    break;
                case '<25000':
                    $query->where('harga', '<', 25000);
                    break;
                case '25000-50000':
                    $query->whereBetween('harga', [25000, 50000]);
                    break;
                case '50000-100000':
                    $query->whereBetween('harga', [50000, 100000]);
                    break;
            }
        }

        // Filter Kuota (sesuai opsi baru)
        if ($request->has('kuota') && $request->kuota != '') {
            switch ($request->kuota) {
                case '0-5':
                    $query->whereRaw('CAST(SUBSTRING_INDEX(kuota, "GB", 1) AS UNSIGNED) BETWEEN 0 AND 5');
                    break;
                case '6-10':
                    $query->whereRaw('CAST(SUBSTRING_INDEX(kuota, "GB", 1) AS UNSIGNED) BETWEEN 6 AND 10');
                    break;
                case '11-15':
                    $query->whereRaw('CAST(SUBSTRING_INDEX(kuota, "GB", 1) AS UNSIGNED) BETWEEN 11 AND 15');
                    break;
                case '16-20':
                    $query->whereRaw('CAST(SUBSTRING_INDEX(kuota, "GB", 1) AS UNSIGNED) BETWEEN 16 AND 20');
                    break;
            }
        }

        // Filter Masa Berlaku (tetap seperti sebelumnya)
        if ($request->has('masa_berlaku') && $request->masa_berlaku != '') {
            $query->whereRaw("CAST(SUBSTRING_INDEX(masa_berlaku, ' ', 1) AS UNSIGNED) < ?", [$request->masa_berlaku]);
        }

        // Tambahkan sorting dari harga termurah ke termahal
        $kuota = $query->orderBy('harga', 'asc')->get();

        return response()->json($kuota);
    }

    // Menampilkan halaman pembayaran
public function showPayment($id_pulsa)
{
    if (!session('id_user')) {
        return redirect('/login');
    }

    // Ambil data pulsa berdasarkan id
    $pulsa = DB::table('pulsa')->where('id_pulsa', $id_pulsa)->first();

    if (!$pulsa) {
        return redirect('/tambah-pulsa')->with('error', 'Data pulsa tidak ditemukan.');
    }

    // Hitung total = pulsa + biaya_admin
    $total = $pulsa->pulsa + $pulsa->biaya_admin;

    return view('pembayaran_pulsa', [
        'id_pulsa'    => $pulsa->id_pulsa,
        'nominal'     => $pulsa->pulsa,
        'biaya_admin' => $pulsa->biaya_admin,
        'total'       => $total,
        'no_hp'       => session('no_hp_user')
    ]);
}
public function processPayment(Request $request)
{
    if (!session('id_user')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $request->validate([
        'id_pulsa'      => 'required|integer',
        'payment_method'=> 'required|string',
        'account_number'=> 'required|string'
    ]);

    $id_pulsa = $request->id_pulsa;
    $userId = session('id_user');
    $no_hp_user = session('no_hp_user');

    $pulsa = DB::table('pulsa')->where('id_pulsa', $id_pulsa)->first();
    if (!$pulsa) {
        return redirect('/tambah-pulsa')->with('error', 'Data pulsa tidak valid.');
    }

    // Tambah pulsa ke saldo user
    DB::table('users')->where('id_user', $userId)->increment('total_pulsa', $pulsa->pulsa);
    session(['total_pulsa' => session('total_pulsa') + $pulsa->pulsa]);

    // Catat transaksi (pulsa_masuk diisi nominal)
    DB::table('transaksi')->insert([
        'id_user'        => $userId,
        'id_kuota'       => null,
        'id_pulsa'       => $id_pulsa,
        'no_hp_user'     => $no_hp_user,
        'pulsa_masuk'    => $pulsa->pulsa,
        'pulsa_keluar'   => 0,
        'status'         => 'berhasil',
        'tanggal'        => now()
    ]);

    return redirect('/home')->with('success', 'Pembelian pulsa Rp' . number_format($pulsa->pulsa, 0, ',', '.') . ' berhasil!');
}

// Menampilkan halaman pembayaran untuk kuota
public function showKuotaPayment($id_kuota)
{
    if (!session('id_user')) {
        return redirect('/login');
    }

    // Ambil data kuota berdasarkan id
    $kuota = DB::table('kuota')->where('id_kuota', $id_kuota)->first();

    if (!$kuota) {
        return redirect('/paket_data')->with('error', 'Data paket tidak ditemukan.');
    }

    // Harga total (misal sudah termasuk biaya admin, jika ada)
    $total = $kuota->harga;

    return view('pembayaran_kuota', [
        'id_kuota' => $kuota->id_kuota,
        'kuota'    => $kuota->kuota,
        'harga'    => $kuota->harga,
        'total'    => $total,
        'no_hp'    => session('no_hp_user')
    ]);
}

// Memproses pembayaran kuota
public function processKuotaPayment(Request $request)
{
    if (!session('id_user')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $request->validate([
        'id_kuota'      => 'required|integer',
        'payment_method'=> 'required|string',
        'account_number'=> 'required|string'
    ]);

    $id_kuota = $request->id_kuota;
    $userId = session('id_user');
    $no_hp_user = session('no_hp_user');

    // Ambil data kuota dari database
    $kuota = DB::table('kuota')->where('id_kuota', $id_kuota)->first();
    if (!$kuota) {
        return redirect('/paket_data')->with('error', 'Data paket tidak valid.');
    }

    // Tambahkan kuota ke saldo user
    DB::table('users')->where('id_user', $userId)->increment('total_kuota', (float) filter_var($kuota->kuota, FILTER_SANITIZE_NUMBER_INT));
    session(['total_kuota' => session('total_kuota') + (float) filter_var($kuota->kuota, FILTER_SANITIZE_NUMBER_INT)]);

    // Simpan transaksi ke tabel transaksi
    DB::table('transaksi')->insert([
        'id_user'        => $userId,
        'id_kuota'       => $id_kuota,
        'id_pulsa'       => null,
        'no_hp_user'     => $no_hp_user,
        'pulsa_terpakai' => 0, // karena ini pembelian kuota, bukan pulsa
        'status'         => 'berhasil',
        'tanggal'        => now()
    ]);

    return redirect('/home')->with('success', 'Pembelian paket data ' . $kuota->kuota . ' berhasil!');
}

public function processPurchaseKuota(Request $request)
{
    if (!session('id_user')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $request->validate([
        'id_kuota'      => 'required|integer',
        'payment_method'=> 'required|string',
        'account_number'=> 'required|string'
    ]);

    $id_kuota = $request->id_kuota;
    $userId = session('id_user');
    $no_hp_user = session('no_hp_user');

    $kuota = DB::table('kuota')->where('id_kuota', $id_kuota)->first();
    if (!$kuota) {
        return redirect('/paket_data')->with('error', 'Data paket tidak valid.');
    }

    $user = DB::table('users')->where('id_user', $userId)->first();
    if (!$user) {
        return redirect('/login')->with('error', 'User tidak ditemukan.');
    }

    // Cek saldo pulsa
    if ($user->total_pulsa < $kuota->harga) {
        return redirect('/home')->with('error', 'pulsa tidak mencukupi.');
    }

    $jumlah_kuota = (float) filter_var($kuota->kuota, FILTER_SANITIZE_NUMBER_INT);

    // Kurangi pulsa, tambah kuota
    DB::table('users')->where('id_user', $userId)->update([
        'total_pulsa' => $user->total_pulsa - $kuota->harga,
        'total_kuota' => $user->total_kuota + $jumlah_kuota
    ]);

    // Update session
    session([
        'total_pulsa' => $user->total_pulsa - $kuota->harga,
        'total_kuota' => $user->total_kuota + $jumlah_kuota
    ]);

    // Catat transaksi (pulsa_keluar diisi harga paket)
    DB::table('transaksi')->insert([
        'id_user'        => $userId,
        'id_kuota'       => $id_kuota,
        'id_pulsa'       => null,
        'no_hp_user'     => $no_hp_user,
        'pulsa_masuk'    => 0,
        'pulsa_keluar'   => $kuota->harga,
        'status'         => 'berhasil',
        'tanggal'        => now()
    ]);

    return redirect('/home')->with('success', 'Pembelian paket data ' . $kuota->kuota . ' berhasil!');
}

public function riwayatTransaksi()
{
    if (!session('id_user')) {
        return redirect('/login');
    }
    $userId = session('id_user');
    $isAdminLevel2 = (int) session('level') === 2;

    $pulsaQuery = DB::table('transaksi')
        ->leftJoin('pulsa', 'transaksi.id_pulsa', '=', 'pulsa.id_pulsa')
        ->leftJoin('users', 'transaksi.id_user', '=', 'users.id_user')
        ->whereNotNull('transaksi.id_pulsa');

    $kuotaQuery = DB::table('transaksi')
        ->leftJoin('kuota', 'transaksi.id_kuota', '=', 'kuota.id_kuota')
        ->leftJoin('users', 'transaksi.id_user', '=', 'users.id_user')
        ->whereNotNull('transaksi.id_kuota');

    if ($isAdminLevel2) {
        $level1UserIds = DB::table('users')
            ->where('level', 1)
            ->pluck('id_user');

        $pulsaQuery->whereIn('transaksi.id_user', $level1UserIds);
        $kuotaQuery->whereIn('transaksi.id_user', $level1UserIds);
    } else {
        $pulsaQuery->where('transaksi.id_user', $userId);
        $kuotaQuery->where('transaksi.id_user', $userId);
    }

    $pulsaTransactions = $pulsaQuery
        ->select(
            'transaksi.*',
            'pulsa.pulsa as nominal_pulsa',
            'pulsa.nama_pulsa',
            'users.nama as user_nama',
            'users.no_hp_user as user_no_hp'
        )
        ->orderBy('transaksi.tanggal', 'desc')
        ->get();

    $kuotaTransactions = $kuotaQuery
        ->select(
            'transaksi.*',
            'kuota.kuota',
            'kuota.harga',
            'kuota.nama_kuota',
            'users.nama as user_nama',
            'users.no_hp_user as user_no_hp'
        )
        ->orderBy('transaksi.tanggal', 'desc')
        ->get();

    return view('riwayat_transaksi', compact('pulsaTransactions', 'kuotaTransactions', 'isAdminLevel2'));
}

public function level1Transactions()
{
    // Cek login
    if (!session('id_user')) {
        return redirect('/login');
    }

    // Izinkan akses untuk level 1 dan level 2 (sesuaikan kebutuhan)
    $allowedLevels = [2]; // jika hanya level 2 yang boleh, ganti menjadi [2]
    if (!in_array(session('level'), $allowedLevels)) {
        return redirect('/home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    // Ambil semua id user dengan level 1
    $level1Users = DB::table('users')->where('level', 1)->pluck('id_user');

    if ($level1Users->isEmpty()) {
        $pulsaTransactions = collect();
        $kuotaTransactions = collect();
    } else {
        $pulsaTransactions = DB::table('transaksi')
            ->join('users', 'transaksi.id_user', '=', 'users.id_user')
            ->leftJoin('pulsa', 'transaksi.id_pulsa', '=', 'pulsa.id_pulsa')
            ->whereIn('transaksi.id_user', $level1Users)
            ->whereNotNull('transaksi.id_pulsa')
            ->select(
                'transaksi.*',
                'users.nama as user_nama',           
                'users.no_hp_user as user_no_hp',
                'pulsa.pulsa as nominal_pulsa',
                'pulsa.nama_pulsa'
            )
            ->orderBy('transaksi.tanggal', 'desc')
            ->get();

        // Transaksi kuota
        $kuotaTransactions = DB::table('transaksi')
            ->join('users', 'transaksi.id_user', '=', 'users.id_user')
            ->leftJoin('kuota', 'transaksi.id_kuota', '=', 'kuota.id_kuota')
            ->whereIn('transaksi.id_user', $level1Users)
            ->whereNotNull('transaksi.id_kuota')
            ->select(
                'transaksi.*',
                'users.nama as user_nama',
                'users.no_hp_user as user_no_hp',
                'kuota.kuota',
                'kuota.harga'
            )
            ->orderBy('transaksi.tanggal', 'desc')
            ->get();
    }

    return view('riwayat_transaksi', compact('pulsaTransactions', 'kuotaTransactions'));
}
}
