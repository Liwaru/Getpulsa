# Dokumentasi Sistem Hak Akses (Permissions)

## 📋 Ringkasan Implementasi

Sistem hak akses berhasil diimplementasikan dengan fitur-fitur berikut:

### ✅ Fitur Utama
1. **Permission Database** - Hak akses disimpan di tabel `permissions`
2. **Sidebar Dynamic** - Menu sidebar otomatis tersembunyi berdasarkan permissions
3. **Route Protection** - Route-route penting dilindungi dengan middleware
4. **Session-based** - Permissions diload saat login dan tersimpan di session

---

## 🔧 Komponen yang Diubah

### 1. **Controller: Control.php**

#### ✏️ `aksi_login()` - Memuat permissions saat login
```php
// Load permissions untuk user berdasarkan level mereka
$permissionsRaw = DB::table('permissions')
    ->where('level', $user->level)
    ->pluck('menu_key')
    ->toArray();

session([
    // ... data user lainnya
    'permissions' => $permissionsRaw, // Simpan permissions di session
]);
```

#### ✏️ `home()` - Update permissions setiap kali halaman home diakses
- Memastikan permissions selalu update di session

#### ✏️ `updateHakAkses()` - Reload permissions setelah update
```php
// Reload permissions untuk current user di session
$currentUserLevel = (int) session('level');
$permissionsRaw = DB::table('permissions')
    ->where('level', $currentUserLevel)
    ->pluck('menu_key')
    ->toArray();

session(['permissions' => $permissionsRaw]);
```

### 2. **View: header.blade.php**

#### ✏️ Sidebar Navigation - Dinamis berdasarkan permissions
```blade
@php
    // Helper function untuk check permission
    $hasPermission = function($menuKey) {
        $permissions = session('permissions', []);
        return in_array($menuKey, $permissions);
    };
@endphp

<!-- Menu hanya ditampilkan jika user punya permission -->
@if($hasPermission('data_transaksi') || count(session('permissions', [])) === 0)
<li>
    <a href="/riwayat-transaksi">
        <i class="bi bi-file-earmark-text"></i> Data Transaksi
    </a>
</li>
@endif
```

### 3. **Helper Class: app/Helpers/PermissionHelper.php** (BARU)

Fungsi-fungsi utility untuk mengecek permissions:

```php
// Check single permission
PermissionHelper::hasPermission('data_user')

// Get all permissions
PermissionHelper::getPermissions()

// Check multiple (semua harus ada)
PermissionHelper::hasAllPermissions(['data_user', 'data_admin'])

// Check multiple (minimal satu ada)
PermissionHelper::hasAnyPermission(['data_user', 'data_admin'])
```

### 4. **Middleware: app/Http/Middleware/CheckMenuPermission.php** (BARU)

Melindungi routes dari akses tanpa permission:

```php
// Jika user tidak memiliki permission untuk menu ini
if (!PermissionHelper::hasPermission($requiredMenuKey)) {
    abort(403, 'Anda tidak memiliki akses ke fitur ini...');
}
```

### 5. **Routes: routes/web.php**

#### ✏️ Protected Routes dengan Middleware
```php
Route::get('/riwayat-transaksi', [Control::class, 'riwayatTransaksi'])
    ->middleware('CheckMenuPermission:data_transaksi')
    ->name('riwayat.transaksi');

Route::get('/data-user', [Control::class, 'dataUser'])
    ->middleware('CheckMenuPermission:data_user')
    ->name('data.user');

Route::get('/data-admin', [Control::class, 'dataAdmin'])
    ->middleware('CheckMenuPermission:data_admin')
    ->name('data.admin');
```

### 6. **Bootstrap: bootstrap/app.php**

#### ✏️ Register Middleware Alias
```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'CheckMenuPermission' => \App\Http\Middleware\CheckMenuPermission::class,
    ]);
})
```

---

## 📊 Struktur Tabel Permissions

```sql
CREATE TABLE permissions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    level INT,              -- Level user (2=Admin, 3=Superadmin)
    menu_key VARCHAR(255),  -- Kunci menu (data_user, data_admin, data_transaksi)
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Data Default yang Sudah Diinsert:
```
Level 2 (Admin):
- profil
- paket_data
- data_user
- data_transaksi

Level 3 (Superadmin):
- paket_data
- data_user
- data_admin
- data_transaksi
```

---

## 🎯 Cara Menggunakan

### 1️⃣ **Login User**
- User login dengan nomor HP
- Sistem otomatis mengambil permissions berdasarkan level user
- Permissions disimpan di session

### 2️⃣ **Menu Sidebar Otomatis Hidden/Visible**
- Sidebar mengecek `session('permissions')`
- Menu hanya ditampilkan jika user memiliki permission untuk menu tersebut
- Jika permissions kosong, semua menu ditampilkan (backward compatibility)

### 3️⃣ **Manage Permissions (Superadmin Only)**
- Buka `/hak-akses` (hanya untuk superadmin)
- Lihat tabel dengan menu dan level (Admin/Superadmin)
- Check/uncheck checkbox untuk memberikan/menghapus akses
- Klik "Simpan Perubahan"
- Permissions di database akan diupdate
- Sidebar untuk semua user akan otomatis berubah

### 4️⃣ **Route Protection**
- Jika user mengakses route yang tidak memiliki permission
- Middleware `CheckMenuPermission` akan return 403 Forbidden
- Pesan error: "Anda tidak memiliki akses ke fitur ini karena menu sudah dinonaktifkan oleh superadmin."

---

## ✨ Fitur-Fitur Keamanan

✅ **Permission Caching** - Permissions disimpan di session, tidak perlu query DB setiap kali  
✅ **Route Protection** - Setiap route yang penting dilindungi middleware  
✅ **Session-based** - Permissions diload ulang setiap kali user akses halaman  
✅ **Graceful Fallback** - Jika permissions table kosong, jalankan seperti biasa (backward compatible)  

---

## 🧪 Testing

### Skenario Test 1: Disable Data Transaksi untuk Superadmin
1. Login sebagai Superadmin (level 3)
2. Akses `/hak-akses`
3. Uncheck "Data Transaksi" untuk Superadmin
4. Klik "Simpan Perubahan"
5. ✅ Menu "Data Transaksi" hilang dari sidebar superadmin
6. ✅ Route `/riwayat-transaksi` menampilkan error 403 jika diakses manual

### Skenario Test 2: Disable Data User untuk Admin
1. Login sebagai Superadmin
2. Akses `/hak-akses`
3. Uncheck "Data User" untuk Admin (level 2)
4. Klik "Simpan Perubahan"
5. Login sebagai Admin
6. ✅ Menu "Data User" hilang dari sidebar admin
7. ✅ Route `/data-user` menampilkan error 403 jika diakses manual

---

## 🔄 Flow Diagram

```
User Login
    ↓
aksi_login() - Query permissions dari database berdasarkan level
    ↓
Simpan permissions di session
    ↓
Redirect ke /home
    ↓
home() - Update permissions di session
    ↓
header.blade.php - Render sidebar
    ↓
Cek setiap menu dengan hasPermission()
    ↓
Tampilkan/sembunyikan menu berdasarkan permissions
```

---

## 📝 Menu Keys yang Tersedia

| Menu Key | Deskripsi |
|----------|-----------|
| `profil` | Halaman profil user |
| `paket_data` | Paket data/kuota |
| `data_user` | Data pengguna |
| `data_admin` | Data admin |
| `data_transaksi` | Riwayat transaksi |

---

## 🚀 Cara Menambah Menu Baru

1. **Update `hakAkses()` di Controller**
```php
$menus = [
    'data_user',
    'data_admin',
    'data_transaksi',
    'laporan_penjualan', // Menu baru
];
```

2. **Update sidebar di header.blade.php**
```blade
@if($hasPermission('laporan_penjualan'))
<li>
    <a href="/laporan-penjualan">
        <i class="bi bi-graph-up"></i> Laporan Penjualan
    </a>
</li>
@endif
```

3. **Add protected route di web.php**
```php
Route::get('/laporan-penjualan', [Control::class, 'laporanPenjualan'])
    ->middleware('CheckMenuPermission:laporan_penjualan')
    ->name('laporan.penjualan');
```

---

## ⚠️ Catatan Penting

- **Backward Compatibility**: Jika permissions table kosong atau user memiliki permissions kosong, semua menu ditampilkan
- **Session Refresh**: Permissions di-update di session pada setiap request ke `/home`
- **Permission Names**: Gunakan snake_case untuk menu keys (contoh: `data_transaksi`, bukan `dataTransaksi`)
- **Middleware Protection**: Selalu tambahkan middleware pada route yang sensitif

---

## 🆘 Troubleshooting

### Menu tidak hilang setelah update permissions
**Solusi**: 
- Clear session: Logout dan login ulang
- Atau akses `/home` untuk refresh permissions

### Error "Class not found" untuk PermissionHelper
**Solusi**: 
- Pastikan file berada di `app/Helpers/PermissionHelper.php`
- Run `composer dump-autoload`

### Middleware tidak berfungsi
**Solusi**: 
- Pastikan middleware sudah di-register di `bootstrap/app.php`
- Check nama middleware di route (harus match)

---

Generated: April 6, 2026
