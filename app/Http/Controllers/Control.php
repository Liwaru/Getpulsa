<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\CoreApi;
use Midtrans\Notification;
use Midtrans\Snap;
use Midtrans\Transaction;

class Control extends Controller
{
    private const E_WALLET_METHODS = [
        'e-wallet_gopay',
        'e-wallet_ovo',
        'e-wallet_dana',
    ];

    private const QRIS_METHOD = 'qris';

    public function logout(Request $request): RedirectResponse
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
            'num2' => $num2,
        ]);

        return view('login');
    }

    public function aksi_login(Request $request): RedirectResponse
    {
        if ($request->captcha != (session('num1') + session('num2'))) {
            return back()->with('error', 'Captcha salah!');
        }

        $user = DB::table('users')
            ->where('no_hp_user', $request->no_hp_user)
            ->first();

        if ($user) {
            session([
                'id_user' => $user->id_user,
                'nama' => $user->nama,
                'no_hp_user' => $user->no_hp_user,
                'level' => $user->level,
                'total_pulsa' => $user->total_pulsa ?? 0,
                'total_kuota' => $user->total_kuota ?? 0,
            ]);

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
            'num2' => $num2,
        ]);

        return view('register');
    }

    public function aksi_register(Request $request): RedirectResponse
    {
        if ($request->captcha != (session('num1') + session('num2'))) {
            return back()->with('error', 'Captcha salah!');
        }

        $request->validate([
            'nama' => 'required',
            'phone' => 'required|unique:users,no_hp_user',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->phone . '@temp.local',
            'password' => bcrypt('password'),
            'no_hp_user' => $request->phone,
            'level' => 1,
            'total_pulsa' => 0,
            'total_kuota' => 0,
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
        'user'  => $user,
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
        $pulsaList = DB::table('pulsa')->orderBy('pulsa', 'asc')->get();

        return view('tambah_pulsa', compact('no_hp_user', 'user', 'pulsaList'));
    }

    public function profil()
    {
        if (!session('id_user')) {
            return redirect('/login');
        }

        $user = DB::table('users')->where('id_user', session('id_user'))->first();

        return view('profil', compact('user'));
    }

    public function updateProfil(Request $request): RedirectResponse
    {
        if (!session('id_user')) {
            return redirect('/login');
        }

        $userId = session('id_user');

        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $updateData = [
            'nama' => $request->nama,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        DB::table('users')->where('id_user', $userId)->update($updateData);

        $updatedUser = DB::table('users')->where('id_user', $userId)->first();
        session([
            'nama' => $updatedUser->nama,
        ]);

        return redirect('/home')->with('success', 'Profil berhasil diperbarui.');
    }

    public function paketData()
    {
        if (!session('id_user')) {
            return redirect('/login');
        }

        $kuota = DB::table('kuota')
            ->orderBy('harga', 'asc')
            ->get();

        return view('paket_data', [
            'no_hp' => session('no_hp_user'),
            'kuota' => $kuota,
        ]);
    }

    public function filterPaket(Request $request): JsonResponse
    {
        $query = DB::table('kuota');

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

        if ($request->has('masa_berlaku') && $request->masa_berlaku != '') {
            $query->whereRaw("CAST(SUBSTRING_INDEX(masa_berlaku, ' ', 1) AS UNSIGNED) < ?", [$request->masa_berlaku]);
        }

        $kuota = $query->orderBy('harga', 'asc')->get();

        return response()->json($kuota);
    }

    public function showPayment($id_pulsa)
    {
        if (!session('id_user')) {
            return redirect('/login');
        }

        $pulsa = DB::table('pulsa')->where('id_pulsa', $id_pulsa)->first();

        if (!$pulsa) {
            return redirect('/tambah-pulsa')->with('error', 'Data pulsa tidak ditemukan.');
        }

        $total = $pulsa->harga ?? $pulsa->pulsa;

        return view('pembayaran_pulsa', [
            'id_pulsa' => $pulsa->id_pulsa,
            'nominal' => $pulsa->pulsa,
            'total' => $total,
            'no_hp' => session('no_hp_user'),
            'midtrans_client_key' => config('midtrans.client_key'),
        ]);
    }

    public function processPayment(Request $request): JsonResponse
    {
        if (!session('id_user')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'id_pulsa' => 'required|integer',
            'payment_method' => 'required|string|in:' . implode(',', self::E_WALLET_METHODS),
            'account_number' => 'nullable|string',
        ]);

        if (!$this->configureMidtrans()) {
            return response()->json([
                'message' => 'Konfigurasi Midtrans belum lengkap.',
            ], 500);
        }

        $pulsa = DB::table('pulsa')->where('id_pulsa', $request->id_pulsa)->first();
        if (!$pulsa) {
            return response()->json(['message' => 'Data pulsa tidak valid.'], 422);
        }

        $user = $this->getCurrentUser();
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan.'], 404);
        }

        $total = $pulsa->harga ?? $pulsa->pulsa;
        $orderId = $this->generateOrderId('pulsa', (int) $pulsa->id_pulsa, (int) $user->id_user);
        $channel = $this->resolveMidtransChannel($request->payment_method);

        DB::beginTransaction();

        try {
            $this->createPendingTransaction([
                'order_id' => $orderId,
                'id_user' => $user->id_user,
                'id_pulsa' => $pulsa->id_pulsa,
                'id_kuota' => null,
                'no_hp_user' => $user->no_hp_user,
                'pulsa_masuk' => $pulsa->pulsa,
                'pulsa_keluar' => 0,
                'payment_method' => $request->payment_method,
                'payment_channel' => $channel,
                'payment_response' => json_encode([
                    'selected_method' => $request->payment_method,
                ]),
            ]);

            $snapToken = Snap::getSnapToken($this->buildPulsaSnapPayload($pulsa, $user, $orderId, $channel, $total));

            DB::commit();

            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $orderId,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Gagal membuat transaksi Midtrans.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function createQrisPayment(Request $request): JsonResponse
    {
        if (!session('id_user')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'payment_type' => 'required|string|in:pulsa,kuota',
            'item_id' => 'required|integer',
        ]);

        if (!$this->configureMidtrans()) {
            return response()->json([
                'message' => 'Konfigurasi Midtrans belum lengkap.',
            ], 500);
        }

        $user = $this->getCurrentUser();
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan.'], 404);
        }

        $resource = $this->resolveQrisResource($request->payment_type, (int) $request->item_id);
        if (!$resource) {
            return response()->json(['message' => 'Data pembayaran tidak ditemukan.'], 422);
        }

        $orderId = $this->generateOrderId($request->payment_type, $resource['entity_id'], (int) $user->id_user);

        DB::beginTransaction();

        try {
            $this->createPendingTransaction([
                'order_id' => $orderId,
                'id_user' => $user->id_user,
                'id_pulsa' => $resource['id_pulsa'],
                'id_kuota' => $resource['id_kuota'],
                'no_hp_user' => $user->no_hp_user,
                'pulsa_masuk' => $resource['pulsa_masuk'],
                'pulsa_keluar' => $resource['pulsa_keluar'],
                'payment_method' => self::QRIS_METHOD,
                'payment_channel' => self::QRIS_METHOD,
                'payment_response' => json_encode([
                    'selected_method' => self::QRIS_METHOD,
                    'payment_type' => $request->payment_type,
                ]),
            ]);

            $chargeResponse = CoreApi::charge($this->buildQrisChargePayload(
                $request->payment_type,
                $resource,
                $user,
                $orderId
            ));

            $this->storeMidtransResponse($orderId, $chargeResponse);

            DB::commit();

            return response()->json([
                'redirect_url' => route('payment.qris.show', ['orderId' => $orderId]),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Gagal membuat pembayaran QRIS.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function showQrisPayment(string $orderId)
    {
        if (!session('id_user')) {
            return redirect('/login');
        }

        $transaction = DB::table('transaksi')->where('order_id', $orderId)->first();
        if (!$transaction || (int) $transaction->id_user !== (int) session('id_user')) {
            return redirect('/home')->with('error', 'Pembayaran QRIS tidak ditemukan.');
        }

        $paymentResponse = $this->decodePaymentResponse($transaction->payment_response);
        $qrUrl = $this->extractQrisQrUrl($paymentResponse);

        if (!$qrUrl) {
            return redirect('/home')->with('error', 'QR code pembayaran tidak tersedia.');
        }

        return view('pembayaran_qris', [
            'transaction' => $transaction,
            'qr_url' => $qrUrl,
            'expires_at' => $this->resolveQrisExpiry($paymentResponse, $transaction->tanggal),
            'display_name' => $this->resolveTransactionDisplayName($transaction),
            'total' => $this->resolveTransactionTotalAmount($transaction),
        ]);
    }

    public function qrisPaymentStatus(string $orderId): JsonResponse
    {
        if (!session('id_user')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if (!$this->configureMidtrans()) {
            return response()->json(['message' => 'Konfigurasi Midtrans belum lengkap.'], 500);
        }

        $transaction = DB::table('transaksi')->where('order_id', $orderId)->first();
        if (!$transaction || (int) $transaction->id_user !== (int) session('id_user')) {
            return response()->json(['message' => 'Pembayaran QRIS tidak ditemukan.'], 404);
        }

        try {
            $midtransStatus = (array) Transaction::status($orderId);
            $updatedTransaction = $this->syncMidtransTransaction($orderId, $midtransStatus);

            if ($updatedTransaction) {
                $this->refreshSessionBalances((int) $updatedTransaction->id_user);
            }

            return response()->json([
                'status' => $updatedTransaction?->status,
                'redirect_url' => url('/home'),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Gagal memeriksa status QRIS.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function showKuotaPayment($id_kuota)
    {
        if (!session('id_user')) {
            return redirect('/login');
        }

        $kuota = DB::table('kuota')->where('id_kuota', $id_kuota)->first();

        if (!$kuota) {
            return redirect('/paket_data')->with('error', 'Data paket tidak ditemukan.');
        }

        $total = $kuota->harga;

        return view('pembayaran_kuota', [
            'id_kuota' => $kuota->id_kuota,
            'kuota' => $kuota->kuota,
            'harga' => $kuota->harga,
            'total' => $total,
            'no_hp' => session('no_hp_user'),
            'midtrans_client_key' => config('midtrans.client_key'),
        ]);
    }

    public function processKuotaPayment(Request $request): JsonResponse
    {
        return $this->processPurchaseKuota($request);
    }

    public function processPurchaseKuota(Request $request): JsonResponse
    {
        if (!session('id_user')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'id_kuota' => 'required|integer',
            'payment_method' => 'required|string|in:' . implode(',', self::E_WALLET_METHODS),
            'account_number' => 'nullable|string',
        ]);

        if (!$this->configureMidtrans()) {
            return response()->json([
                'message' => 'Konfigurasi Midtrans belum lengkap.',
            ], 500);
        }

        $kuota = DB::table('kuota')->where('id_kuota', $request->id_kuota)->first();
        if (!$kuota) {
            return response()->json(['message' => 'Data paket tidak valid.'], 422);
        }

        $user = $this->getCurrentUser();
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan.'], 404);
        }

        $orderId = $this->generateOrderId('kuota', (int) $kuota->id_kuota, (int) $user->id_user);
        $channel = $this->resolveMidtransChannel($request->payment_method);

        DB::beginTransaction();

        try {
            $this->createPendingTransaction([
                'order_id' => $orderId,
                'id_user' => $user->id_user,
                'id_pulsa' => null,
                'id_kuota' => $kuota->id_kuota,
                'no_hp_user' => $user->no_hp_user,
                'pulsa_masuk' => 0,
                'pulsa_keluar' => $kuota->harga,
                'payment_method' => $request->payment_method,
                'payment_channel' => $channel,
                'payment_response' => json_encode([
                    'selected_method' => $request->payment_method,
                ]),
            ]);

            $snapToken = Snap::getSnapToken($this->buildKuotaSnapPayload($kuota, $user, $orderId, $channel));

            DB::commit();

            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $orderId,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Gagal membuat transaksi Midtrans.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function midtransFinish(Request $request): JsonResponse
    {
        $request->validate([
            'order_id' => 'required|string',
        ]);

        if (!$this->configureMidtrans()) {
            return response()->json(['message' => 'Konfigurasi Midtrans belum lengkap.'], 500);
        }

        try {
            $midtransStatus = (array) Transaction::status($request->order_id);
            $transaction = $this->syncMidtransTransaction($request->order_id, $midtransStatus);

            if ($transaction && session('id_user') && (int) session('id_user') === (int) $transaction->id_user) {
                $this->refreshSessionBalances((int) $transaction->id_user);
            }

            return response()->json([
                'message' => 'Status pembayaran diperbarui.',
                'status' => $transaction?->status,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Gagal memeriksa status pembayaran.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function midtransNotification(Request $request): JsonResponse
    {
        if (!$this->configureMidtrans()) {
            return response()->json(['message' => 'Konfigurasi Midtrans belum lengkap.'], 500);
        }

        try {
            $notification = new Notification();
            $payload = json_decode(json_encode($notification), true) ?: [];
            $orderId = $payload['order_id'] ?? null;

            if (!$orderId) {
                return response()->json(['message' => 'Order ID tidak ditemukan.'], 422);
            }

            $this->syncMidtransTransaction($orderId, $payload);

            return response()->json(['message' => 'Notification processed.']);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Gagal memproses notifikasi Midtrans.',
                'error' => $e->getMessage(),
            ], 500);
        }
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

    // Ambil level & pastikan integer
    $level = (int) session('level');

    // Hanya level 2 & 3 yang boleh akses
    if (!in_array($level, [2, 3], true)) {
        return redirect('/home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    // Ambil semua user level 1
    $level1Users = DB::table('users')
        ->where('level', 1)
        ->pluck('id_user');

    // Kalau tidak ada user level 1
    if ($level1Users->isEmpty()) {
        $pulsaTransactions = collect();
        $kuotaTransactions = collect();
    } else {

        // ======================
        // TRANSAKSI PULSA
        // ======================
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

        // ======================
        // TRANSAKSI KUOTA
        // ======================
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

    // Kirim ke view
    return view('riwayat_transaksi', compact('pulsaTransactions', 'kuotaTransactions'));
}
    public function dataUser(Request $request)
    {
        if (!session('id_user')) {
            return redirect('/login');
        }

        $allowedLevels = [2, 3];
        if (!in_array((int) session('level'), $allowedLevels, true)) {
            return redirect('/home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $search = trim((string) $request->get('search', ''));

        $usersQuery = DB::table('users')
            ->where('level', 1)
            ->select('id_user', 'nama', 'no_hp_user')
            ->orderBy('nama', 'asc');

        if ($search !== '') {
            $usersQuery->where(function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('no_hp_user', 'like', '%' . $search . '%');
            });
        }

        $users = $usersQuery->get();

        return view('data_user', [
            'users' => $users,
            'search' => $search,
        ]);
    }

    private function configureMidtrans(): bool
    {
        if (!class_exists(Config::class) || !config('midtrans.server_key') || !config('midtrans.client_key')) {
            return false;
        }

        Config::$serverKey = (string) config('midtrans.server_key');
        Config::$clientKey = (string) config('midtrans.client_key');
        Config::$isProduction = (bool) config('midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        return true;
    }

    private function getCurrentUser(): ?object
    {
        return DB::table('users')->where('id_user', session('id_user'))->first();
    }

    private function refreshSessionBalances(int $userId): void
    {
        $user = DB::table('users')->where('id_user', $userId)->first();

        if (!$user) {
            return;
        }

        session([
            'total_pulsa' => $user->total_pulsa ?? 0,
            'total_kuota' => $user->total_kuota ?? 0,
        ]);
    }

    private function generateOrderId(string $type, int $entityId, int $userId): string
    {
        return strtoupper($type) . '-' . $entityId . '-' . $userId . '-' . now()->format('YmdHis') . '-' . str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
    }

    private function resolveMidtransChannel(string $paymentMethod): string
    {
        return match ($paymentMethod) {
            'e-wallet_gopay' => 'gopay',
            'e-wallet_ovo' => 'ovo',
            'e-wallet_dana' => 'dana',
            default => 'qris',
        };
    }

    private function createPendingTransaction(array $data): void
    {
        DB::table('transaksi')->insert([
            'id_user' => $data['id_user'],
            'id_kuota' => $data['id_kuota'],
            'id_pulsa' => $data['id_pulsa'],
            'no_hp_user' => $data['no_hp_user'],
            'pulsa_masuk' => $data['pulsa_masuk'],
            'pulsa_keluar' => $data['pulsa_keluar'],
            'status' => 'diproses',
            'tanggal' => now(),
            'order_id' => $data['order_id'],
            'payment_method' => $data['payment_method'],
            'payment_channel' => $data['payment_channel'],
            'payment_response' => $data['payment_response'],
        ]);
    }

    private function buildPulsaSnapPayload(object $pulsa, object $user, string $orderId, string $channel, int $total): array
    {
        $items = [[
            'id' => 'PULSA-' . $pulsa->id_pulsa,
            'price' => (int) $pulsa->pulsa,
            'quantity' => 1,
            'name' => $pulsa->nama_pulsa ?: ('Pulsa ' . number_format($pulsa->pulsa, 0, ',', '.')),
        ]];

        return [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $total,
            ],
            'item_details' => $items,
            'customer_details' => [
                'first_name' => $user->nama,
                'phone' => $user->no_hp_user,
            ],
            'enabled_payments' => [$channel],
        ];
    }

    private function resolveQrisResource(string $paymentType, int $itemId): ?array
    {
        if ($paymentType === 'pulsa') {
            $pulsa = DB::table('pulsa')->where('id_pulsa', $itemId)->first();
            if (!$pulsa) {
                return null;
            }

            return [
                'entity_id' => (int) $pulsa->id_pulsa,
                'id_pulsa' => (int) $pulsa->id_pulsa,
                'id_kuota' => null,
                'name' => $pulsa->nama_pulsa ?: ('Pulsa ' . number_format($pulsa->pulsa, 0, ',', '.')),
                'amount' => (int) ($pulsa->harga ?? $pulsa->pulsa),
                'pulsa_masuk' => (int) $pulsa->pulsa,
                'pulsa_keluar' => 0,
            ];
        }

        $kuota = DB::table('kuota')->where('id_kuota', $itemId)->first();
        if (!$kuota) {
            return null;
        }

        return [
            'entity_id' => (int) $kuota->id_kuota,
            'id_pulsa' => null,
            'id_kuota' => (int) $kuota->id_kuota,
            'name' => $kuota->nama_kuota ?: ('Paket Data ' . $kuota->kuota),
            'amount' => (int) $kuota->harga,
            'pulsa_masuk' => 0,
            'pulsa_keluar' => (int) $kuota->harga,
        ];
    }

    private function buildQrisChargePayload(string $paymentType, array $resource, object $user, string $orderId): array
    {
        return [
            'payment_type' => 'qris',
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $resource['amount'],
            ],
            'item_details' => [[
                'id' => strtoupper($paymentType) . '-' . $resource['entity_id'],
                'price' => $resource['amount'],
                'quantity' => 1,
                'name' => $resource['name'],
            ]],
            'customer_details' => [
                'first_name' => $user->nama,
                'phone' => $user->no_hp_user,
            ],
            'custom_expiry' => [
                'order_time' => now()->format('Y-m-d H:i:s O'),
                'expiry_duration' => 30,
                'unit' => 'minute',
            ],
        ];
    }

    private function storeMidtransResponse(string $orderId, array|object $response): void
    {
        $payload = json_decode(json_encode($response), true) ?: [];

        DB::table('transaksi')
            ->where('order_id', $orderId)
            ->update([
                'payment_channel' => $payload['payment_type'] ?? self::QRIS_METHOD,
                'midtrans_transaction_id' => $payload['transaction_id'] ?? null,
                'payment_response' => json_encode($payload),
            ]);
    }

    private function decodePaymentResponse(?string $payload): array
    {
        $decoded = json_decode((string) $payload, true);

        return is_array($decoded) ? $decoded : [];
    }

    private function extractQrisQrUrl(array $payload): ?string
    {
        foreach (($payload['actions'] ?? []) as $action) {
            if (($action['name'] ?? null) === 'generate-qr-code' && !empty($action['url'])) {
                return $action['url'];
            }
        }

        return null;
    }

    private function resolveQrisExpiry(array $payload, ?string $fallbackDate): string
    {
        if (!empty($payload['expiry_time'])) {
            return $payload['expiry_time'];
        }

        return date('Y-m-d H:i:s', strtotime((string) $fallbackDate . ' +30 minutes'));
    }

    private function resolveTransactionDisplayName(object $transaction): string
    {
        if ($transaction->id_pulsa) {
            $pulsa = DB::table('pulsa')->where('id_pulsa', $transaction->id_pulsa)->first();
            if ($pulsa) {
                return $pulsa->nama_pulsa ?: ('Pulsa ' . number_format($pulsa->pulsa, 0, ',', '.'));
            }
        }

        if ($transaction->id_kuota) {
            $kuota = DB::table('kuota')->where('id_kuota', $transaction->id_kuota)->first();
            if ($kuota) {
                return $kuota->nama_kuota ?: ('Paket Data ' . $kuota->kuota);
            }
        }

        return 'Pembayaran QRIS';
    }

    private function resolveTransactionTotalAmount(object $transaction): int
    {
        if ((int) $transaction->pulsa_keluar > 0) {
            return (int) $transaction->pulsa_keluar;
        }

        return (int) $transaction->pulsa_masuk;
    }

    private function buildKuotaSnapPayload(object $kuota, object $user, string $orderId, string $channel): array
    {
        return [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $kuota->harga,
            ],
            'item_details' => [[
                'id' => 'KUOTA-' . $kuota->id_kuota,
                'price' => (int) $kuota->harga,
                'quantity' => 1,
                'name' => $kuota->nama_kuota ?: ('Paket Data ' . $kuota->kuota),
            ]],
            'customer_details' => [
                'first_name' => $user->nama,
                'phone' => $user->no_hp_user,
            ],
            'enabled_payments' => [$channel],
        ];
    }

    private function syncMidtransTransaction(string $orderId, array $payload): ?object
    {
        $transaction = DB::table('transaksi')->where('order_id', $orderId)->first();
        if (!$transaction) {
            return null;
        }

        $nextStatus = $this->mapMidtransStatusToLocal($payload);
        $updates = [
            'status' => $nextStatus,
            'payment_channel' => $payload['payment_type'] ?? $transaction->payment_channel,
            'midtrans_transaction_id' => $payload['transaction_id'] ?? $transaction->midtrans_transaction_id,
            'payment_response' => json_encode($payload),
        ];

        if ($nextStatus === 'berhasil' && !$transaction->settled_at) {
            $updates['settled_at'] = now();
        }

        DB::table('transaksi')
            ->where('id_transaksi', $transaction->id_transaksi)
            ->update($updates);

        if ($transaction->status !== 'berhasil' && $nextStatus === 'berhasil') {
            $this->fulfillSuccessfulTransaction($transaction);
        }

        return DB::table('transaksi')->where('id_transaksi', $transaction->id_transaksi)->first();
    }

    private function mapMidtransStatusToLocal(array $payload): string
    {
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        if ($transactionStatus === 'capture') {
            return $fraudStatus === 'challenge' ? 'diproses' : 'berhasil';
        }

        return match ($transactionStatus) {
            'settlement' => 'berhasil',
            'pending', 'authorize' => 'diproses',
            'deny', 'cancel', 'expire', 'failure', 'refund', 'partial_refund', 'chargeback', 'partial_chargeback' => 'gagal',
            default => 'diproses',
        };
    }

    private function fulfillSuccessfulTransaction(object $transaction): void
    {
        if ($transaction->id_pulsa) {
            DB::table('users')
                ->where('id_user', $transaction->id_user)
                ->increment('total_pulsa', (int) $transaction->pulsa_masuk);

            return;
        }

        if ($transaction->id_kuota) {
            $kuota = DB::table('kuota')->where('id_kuota', $transaction->id_kuota)->first();
            if (!$kuota) {
                return;
            }

            $jumlahKuota = (float) filter_var($kuota->kuota, FILTER_SANITIZE_NUMBER_INT);

            DB::table('users')
                ->where('id_user', $transaction->id_user)
                ->increment('total_kuota', $jumlahKuota);
        }
    }
}
