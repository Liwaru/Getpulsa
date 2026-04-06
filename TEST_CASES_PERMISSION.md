# Test Cases - Sistem Hak Akses

## 📝 Quick Start Test

### Prerequisites
- Database terisi dengan user test
- Admin (level 2) dan Superadmin (level 3) sudah ada
- Server running di `http://127.0.0.1:8000`

---

## Test Case 1: Default Permissions di Login

**Tujuan**: Memverifikasi bahwa sistem memuat permissions saat user login

**Langkah**:
1. Buka `http://127.0.0.1:8000/login`
2. Login dengan akun Admin (level 2)
3. Amati sidebar di halaman home

**Expected Result** ✅:
- Sidebar menampilkan menu:
  - Profil
  - Paket Data
  - Data User
  - Data Transaksi
  - Logout

**Verifikasi** (Developer Tools):
- Buka Dev Tools → Application → Cookies → Lihat session
- Session harus contain `permissions: ['profil', 'paket_data', 'data_user', 'data_transaksi']`

---

## Test Case 2: Disable Menu - Data Transaksi untuk Superadmin

**Tujuan**: Memverifikasi bahwa menu bisa dihidden dengan menon-aktifkan di management

**Langkah**:
1. Logout dari akun sebelumnya
2. Login sebagai Superadmin (level 3)
3. Klik menu "Hak Akses" di sidebar
4. Lihat tabel dengan menu dan level
5. Uncheck "Data Transaksi" di kolom Superadmin
6. Klik button "Simpan Perubahan"
7. Tunggu halaman reload

**Expected Result** ✅:
- Halaman reload
- Toast/alert "Hak akses berhasil diperbarui."
- Sidebar refresh
- Menu "Data Transaksi" **HILANG** dari sidebar superadmin

**Verifikasi**:
- Coba akses langsung ke `/riwayat-transaksi`
- Should return 403 Forbidden dengan message "Anda tidak memiliki akses ke fitur ini..."

---

## Test Case 3: Disable Menu - Data User untuk Admin

**Tujuan**: Memverifikasi permission system bekerja untuk multiple levels

**Langkah**:
1. Masih login sebagai Superadmin
2. Buka `/hak-akses` lagi
3. Uncheck "Data User" di kolom Admin (level 2)
4. Klik "Simpan Perubahan"
5. Logout
6. Login sebagai Admin (level 2)

**Expected Result** ✅:
- Admin login berhasil
- Sidebar **TIDAK** menampilkan "Data User"
- Menu yang ada:
  - Profil
  - Paket Data
  - Data Transaksi
  - Logout

---

## Test Case 4: Re-enable Menu

**Tujuan**: Memverifikasi bahwa menu bisa di-enable kembali

**Langkah**:
1. Login kembali sebagai Superadmin
2. Buka `/hak-akses`
3. Check/centang "Data User" untuk Admin
4. Klik "Simpan Perubahan"
5. Logout → Login sebagai Admin

**Expected Result** ✅:
- Admin sekarang bisa melihat "Data User" di sidebar
- Bisa akses `/data-user` tanpa error

---

## Test Case 5: Multiple Menu Disable

**Tujuan**: Memverifikasi sistem bekerja dengan multiple menus di-disable

**Langkah**:
1. Login sebagai Superadmin
2. Buka `/hak-akses`
3. Uncheck multiple menus untuk Admin:
   - Data User
   - Data Transaksi
4. Klik "Simpan Perubahan"
5. Login sebagai Admin

**Expected Result** ✅:
- Admin sidebar hanya menampilkan:
  - Profil
  - Paket Data
  - Logout
- Akses ke `/data-user` dan `/riwayat-transaksi` return 403

---

## Test Case 6: Superadmin Menu Management

**Tujuan**: Memverifikasi bahwa superadmin bisa mengelola permissions sendiri

**Langkah**:
1. Login sebagai Superadmin
2. Check current permissions (lihat tabel)
3. Uncheck "Data Admin" untuk Superadmin
4. Klik "Simpan Perubahan"
5. Refresh halaman atau go to `/hak-akses` lagi

**Expected Result** ✅:
- Menu "Data Admin" menghilang dari sidebar superadmin
- Tapi halaman `/hak-akses` masih accessible (tidak di-protect)
- Jika coba akses `/data-admin` akan return 403

---

## Test Case 7: Session Refresh

**Tujuan**: Memverifikasi bahwa permissions selalu up-to-date di session

**Langkah**:
1. Login sebagai Superadmin dengan "Data Transaksi" enabled
2. Navigate ke `/home` (button home di sidebar atau direct URL)
3. Check session permissions di Dev Tools
4. Logout
5. Superadmin lain disable "Data Transaksi"
6. Login kembali sebagai Superadmin pertama

**Expected Result** ✅:
- Permissions di session selalu update dengan database latest

---

## Test Case 8: Middleware Protection

**Tujuan**: Memverifikasi route protection middleware

**Langkah**:
1. Login sebagai Admin dengan "Data User" disabled
2. Buka dev console (F12)
3. Type: `fetch('/data-user')`
4. Lihat response

**Expected Result** ✅:
- Response status: 403
- Response body: HTML error page dengan message tentang akses ditolak

---

## Test Case 9: Permission Names Case Sensitivity

**Tujuan**: Memverifikasi permission check tidak case-sensitive (jika needed)

**Langkah**:
1. Check database permissions table
2. Verify semua menu_key menggunakan snake_case

**Expected Result** ✅:
- Semua entries: `data_user`, `data_admin`, `data_transaksi`, etc.

---

## Test Case 10: Backward Compatibility

**Tujuan**: Memverifikasi sistem bekerja jika permissions table kosong

**Langkah**:
1. Jika ingin test ini, backup permissions lalu truncate table
2. Login sebagai user
3. Check sidebar
4. Restore data

**Expected Result** ✅:
- User bisa access semua menu meski permissions kosong
- Sidebar menampilkan semua menu untuk level tersebut

---

## 🐛 Debugging Tips

### Check Permissions di Session
```php
// Di dalam blade file:
{{ json_encode(session('permissions')) }}

// Atau di console/tinker:
session('permissions')
```

### Check Database Permissions
```php
// Via tinker:
DB::table('permissions')->get()
DB::table('permissions')->where('level', 2)->get()
```

### Enable Query Log
```php
// Di controller atau middleware:
DB::enableQueryLog();
// ... code ...
dd(DB::getQueryLog());
```

### Check Middleware Registration
```php
// Verify di bootstrap/app.php:
php artisan route:list | grep CheckMenuPermission
```

---

## ✅ Checklist - Verifikasi Semua Fitur

- [ ] Login memuat permissions dari DB
- [ ] Sidebar menampilkan/menyembunyikan menu sesuai permissions
- [ ] Disabled menu tidak tampil di sidebar
- [ ] Protected route return 403 jika no permission
- [ ] Superadmin bisa manage permissions di `/hak-akses`
- [ ] Update permissions langsung refresh sidebar
- [ ] Multiple menus bisa di-disable sekaligus
- [ ] Session permissions always up-to-date
- [ ] Backward compatibility jika permissions kosong
- [ ] PermissionHelper class accessible dari view/controller

---

## 📊 Test Data

### User Test - Admin (Level 2)
```
No HP: (sesuai di DB)
Password: (sesuai di DB)
Level: 2
Expected Menus:
  - Profil
  - Paket Data
  - Data User
  - Data Transaksi
```

### User Test - Superadmin (Level 3)
```
No HP: (sesuai di DB)
Password: (sesuai di DB)
Level: 3
Expected Menus:
  - Paket Data
  - Data User
  - Data Admin
  - Data Transaksi
  - Hak Akses
```

---

## 💡 Notes

- Test ini menggunakan browser UI
- Untuk testing API/route langsung, gunakan Postman/curl dengan session cookie
- Always verify di 2+ browser jika possible (untuk test session management)
- Clear browser cache setelah test jika ada weird behavior

---

Created: April 6, 2026
