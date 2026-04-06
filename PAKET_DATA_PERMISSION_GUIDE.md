# Panduan Fitur Paket Data Permission

## 📋 Apa yang Baru

Fitur **Paket Data** sekarang sudah bisa dikelola di halaman Hak Akses seperti fitur-fitur lainnya (Data User, Data Admin, Data Transaksi).

---

## 🎯 Fitur Paket Data Permission

### Menu Item
- **Nama Menu**: Paket Data
- **Menu Key**: `paket_data`
- **URL**: `/paket_data`
- **Diakses oleh**: Admin (level 2), Superadmin (level 3)

### Sidebar Display
- Paket Data muncul di sidebar untuk **Admin** dan **Superadmin** jika permission enabled
- Jika permission di-disable, menu akan hilang dari sidebar

### Route Protection
- Route `/paket_data` dilindungi dengan middleware `CheckMenuPermission:paket_data`
- Route `/paket_data/filter` juga dilindungi dengan middleware yang sama

---

## 🔧 Implement Details

### 1. Controller - Control.php
```php
// Di hakAkses() - Paket Data sekarang termasuk dalam list menus yang bisa dikelola
$menus = [
    'paket_data',      // ← BARU
    'data_user',
    'data_admin',
    'data_transaksi',
];
```

### 2. Database - permissions table
```
Level 2 (Admin):
✓ paket_data
✓ profil
✓ data_user
✓ data_transaksi

Level 3 (Superadmin):
✓ paket_data
✓ data_user
✓ data_admin
✓ data_transaksi
```

### 3. View - header.blade.php
```blade
<!-- Superadmin -->
@if($hasPermission('paket_data') || count(session('permissions', [])) === 0)
<li>
    <a href="/paket_data">
        <i class="bi bi-box"></i> Paket Data
    </a>
</li>
@endif

<!-- Admin -->
@if($hasPermission('paket_data') || count(session('permissions', [])) === 0)
<li>
    <a href="/paket_data">
        <i class="bi bi-box"></i> Paket Data
    </a>
</li>
@endif
```

### 4. Routes - web.php
```php
Route::get('/paket_data', [Control::class, 'paketData'])
    ->middleware('CheckMenuPermission:paket_data')
    ->name('paket.data');

Route::get('/paket_data/filter', [Control::class, 'filterPaket'])
    ->middleware('CheckMenuPermission:paket_data')
    ->name('paket.filter');
```

---

## 🧪 Test Scenario: Disable Paket Data untuk Superadmin

### Step 1: Login sebagai Superadmin
```
No HP: (superadmin account)
Password: (password)
```

### Step 2: Navigate ke Hak Akses
```
Klik menu "Hak Akses" di sidebar
atau Langsung ke: http://localhost:8000/hak-akses
```

### Step 3: Lihat Tabel Management
Akan melihat tabel:

| Menu | Admin | Superadmin |
|------|-------|-----------|
| Paket Data | ☑ | ☑ |
| Data User | ☑ | ☑ |
| Data Admin | | ☑ |
| Data Transaksi | ☑ | ☑ |

### Step 4: Disable Paket Data untuk Superadmin
- Uncheck checkbox **Paket Data** di kolom **Superadmin**
- Checkbox lainnya tetap checked

### Step 5: Simpan Perubahan
```
Klik button "Simpan Perubahan"
```

### Step 6: Verifikasi
✅ **Expected Result**:
1. Page reload dengan success message: "Hak akses berhasil diperbarui."
2. Sidebar refresh otomatis
3. Menu "Paket Data" **HILANG** dari sidebar superadmin
4. Menu yang tersisa: Data User, Data Admin, Data Transaksi, Hak Akses, Logout
5. Jika coba akses `/paket_data` langsung → Error 403 Forbidden

---

## 🧪 Test Scenario: Re-enable Paket Data untuk Superadmin

### Step 1: Masih di halaman Hak Akses

### Step 2: Check kembali "Paket Data" untuk Superadmin
- Centang checkbox **Paket Data** di kolom **Superadmin**

### Step 3: Simpan Perubahan
```
Klik button "Simpan Perubahan"
```

### Step 4: Verifikasi
✅ **Expected Result**:
1. Menu "Paket Data" muncul kembali di sidebar
2. Route `/paket_data` bisa diakses normal
3. Filter paket data berfungsi normal

---

## 🧪 Test Scenario: Disable Paket Data untuk Admin

### Step 1: Login sebagai Superadmin

### Step 2: Klik "Hak Akses"

### Step 3: Uncheck "Paket Data" untuk Admin (Level 2)
- Lihat kolom Admin, uncheck Paket Data

### Step 4: Simpan Perubahan

### Step 5: Logout kemudian Login sebagai Admin

### Step 6: Verifikasi
✅ **Expected Result**:
1. Admin sidebar **TIDAK** menampilkan "Paket Data"
2. Admin sidebar menampilkan: Profil, Data User, Data Transaksi, Logout
3. Jika Admin coba akses `/paket_data` langsung → Error 403 Forbidden

---

## 📊 Default Permissions After Update

```
Admin (Level 2):
✓ profil
✓ paket_data       ← Sekarang termasuk
✓ data_user
✓ data_transaksi

Superadmin (Level 3):
✓ paket_data       ← Sekarang termasuk
✓ data_user
✓ data_admin
✓ data_transaksi
```

---

## 💾 Database Status

Permissions table data:
```sql
SELECT * FROM permissions ORDER BY level, menu_key;

level | menu_key
------|----------------
2     | data_transaksi
2     | data_user
2     | paket_data
2     | profil
3     | data_admin
3     | data_transaksi
3     | data_user
3     | paket_data
```

---

## ✨ Fitur Lengkap Menu yang Bisa Dimanage

Total 5 menu yang bisa dimanage di halaman Hak Akses:

| Menu | Key | Level 2 (Admin) | Level 3 (Superadmin) |
|------|-----|-----------------|----------------------|
| Profil | `profil` | ✓ | - |
| Paket Data | `paket_data` | ✓ | ✓ |
| Data User | `data_user` | ✓ | ✓ |
| Data Admin | `data_admin` | - | ✓ |
| Data Transaksi | `data_transaksi` | ✓ | ✓ |

*Catatan: Level 1 (Customer) tidak bisa dimanage di halaman Hak Akses*

---

## 🚨 Penting

- **Paket Data** adalah public menu yang bisa diakses oleh Admin dan Superadmin
- Menu ini berbeda dengan **Data User** yang merupakan menu admin-only
- Jika Superadmin menge-disable Paket Data, Admin tetap bisa access (jika Admin punya permission)
- Sebaliknya, jika Admin punya permission, Superadmin tidak bisa disable akses Admin

---

## 🔄 Updates Made

1. ✅ Added `'paket_data'` to $menus in `hakAkses()` method
2. ✅ Updated database permissions to include `paket_data` for both Admin (level 2) and Superadmin (level 3)
3. ✅ Sidebar conditionals already support `paket_data` (done in previous implementation)
4. ✅ Routes already protected with `CheckMenuPermission:paket_data` middleware

---

Created: April 6, 2026
