# Panduan Menghapus Field Tidak Digunakan

## 📋 Ringkasan

Berdasarkan analisis menyeluruh, kedua field berikut **TIDAK DIGUNAKAN** di aplikasi dan AMAN untuk dihapus:

- ❌ `harga_modal` (di tabel pulsa dan kuota)
- ❌ `harga_jual` (di tabel pulsa dan kuota)

**Total: 4 field yang dapat dihapus**

---

## ⚠️ LANGKAH PERSIAPAN (WAJIB)

### 1️⃣ **BACKUP DATABASE TERLEBIH DAHULU**

```bash
# Windows - MySQL
mysqldump -u root -p nama_database > backup_20260406.sql

# Linux/Mac
mysqldump -u root -p nama_database > backup_20260406.sql
```

**Simpan file backup di lokasi aman!**

### 2️⃣ **Verifikasi Field Ada di Database**

Buka database management tool (phpMyAdmin, MySQL Workbench, atau terminal):

```sql
-- Lihat struktur tabel pulsa
DESCRIBE pulsa;

-- Lihat struktur tabel kuota
DESCRIBE kuota;
```

Pastikan field berikut ada:
- `harga_modal`
- `harga_jual`

---

## 🚀 CARA MENGHAPUS (2 OPSI)

### OPSI 1: Via Laravel Migration (Recommended)

**Step 1: Run Migration**
```bash
cd c:\Users\Hendra\ Huang\Documents\new\ laravel\Getpulsa

php artisan migrate
```

**Output yang diharapkan:**
```
Migrating: 2026_04_06_delete_unused_fields
Migrated:  2026_04_06_delete_unused_fields (0.XX seconds)
```

**Selesai!** Field sudah dihapus dari database.

---

### OPSI 2: Manual SQL Query

Jika lebih suka langsung execute SQL:

**Step 1: Backup terlebih dahulu** (PENTING!)

**Step 2: Execute queries berikut:**

```sql
-- Hapus dari tabel PULSA
ALTER TABLE pulsa DROP COLUMN IF EXISTS harga_modal;
ALTER TABLE pulsa DROP COLUMN IF EXISTS harga_jual;

-- Hapus dari tabel KUOTA
ALTER TABLE kuota DROP COLUMN IF EXISTS harga_modal;
ALTER TABLE kuota DROP COLUMN IF EXISTS harga_jual;
```

**Selesai!**

---

## ✅ VERIFIKASI SETELAH PENGHAPUSAN

Pastikan field sudah dihapus:

```sql
-- Verifikasi tabel pulsa
DESCRIBE pulsa;
-- Seharusnya field harga_modal dan harga_jual tidak ada di list

-- Verifikasi tabel kuota
DESCRIBE kuota;
-- Seharusnya field harga_modal dan harga_jual tidak ada di list
```

---

## 🛞 TROUBLESHOOTING

### Error: "Unknown column 'harga_modal'"
**Solusi**: Field sudah dihapus sebelumnya atau tidak pernah ada. Tidak masalah, lanjutkan saja.

### Error: "Specified key was too long"
**Solusi**: Uncommon, tapi coba rollback dan backup data:
```bash
php artisan migrate:rollback
# Restore dari backup jika ada masalah
```

### Lupa backup?
**Solusi**: Jika masalah terjadi:
1. Stop aplikasi
2. Jangan operasional lebih lanjut
3. Hubungi backup service atau database recovery service

---

## 📊 Struktur Field Sebelum & Sesudah

### PULSA - Sebelum
```
id_pulsa         INT
pulsa            INT
harga            INT
harga_modal      INT  ← AKAN DIHAPUS
harga_jual       INT  ← AKAN DIHAPUS
nama_pulsa       VARCHAR
created_at       TIMESTAMP
updated_at       TIMESTAMP
```

### PULSA - Sesudah
```
id_pulsa         INT
pulsa            INT
harga            INT
nama_pulsa       VARCHAR
created_at       TIMESTAMP
updated_at       TIMESTAMP
```

### KUOTA - Sebelum
```
id_kuota         INT
kuota            VARCHAR
harga            INT
harga_modal      INT  ← AKAN DIHAPUS
harga_jual       INT  ← AKAN DIHAPUS
nama_kuota       VARCHAR
masa_berlaku     INT
created_at       TIMESTAMP
updated_at       TIMESTAMP
```

### KUOTA - Sesudah
```
id_kuota         INT
kuota            VARCHAR
harga            INT
nama_kuota       VARCHAR
masa_berlaku     INT
created_at       TIMESTAMP
updated_at       TIMESTAMP
```

---

## 🎯 Alasan Penghapusan

1. ✅ **Not Used in Code** - Tidak digunakan di mana pun dalam aplikasi
2. ✅ **Security** - Mengurangi data sensitif (cost info) yang tidak perlu
3. ✅ **Database Cleanup** - Keeping database schema clean
4. ✅ **Performance** - Mengurangi beban SELECT queries (meski minor)

---

## 📝 Checklist Sebelum Eksekusi

- [ ] Sudah backup database
- [ ] Sudah verifikasi field ada di database
- [ ] Sudah read file ANALISIS_FIELD_TIDAK_DIGUNAKAN.md
- [ ] Sudah inform team tentang perubahan ini
- [ ] Ready untuk execute penghapusan
- [ ] Ada plan rollback jika ada issue

---

## 🔄 Jika Ada Masalah Setelah Penghapusan

### Rollback dari Backup:

**Windows:**
```bash
mysql -u root -p nama_database < backup_20260406.sql
```

**Linux/Mac:**
```bash
mysql -u root -p nama_database < backup_20260406.sql
```

---

## 📞 FAQ

**Q: Apakah aplikasi akan error setelah field dihapus?**  
A: Tidak, karena field ini tidak pernah digunakan dalam kode apapun.

**Q: Bisakah di-rollback?**  
A: Ya, dengan restore dari backup. Migration file sengaja tidak support rollback karena data akan dihapus.

**Q: Apakah perlu restart server?**  
A: Tidak, Laravel akan handle otomatis.

**Q: Berapa lama prosesnya?**  
A: Hanya beberapa detik untuk 2 tabel kecil.

---

## ⏰ Timeline

- **Backup**: 1-2 menit
- **Run Migration**: < 5 detik
- **Verify**: 1-2 menit
- **Total**: ~5 menit

---

## 🔐 Safety Notes

✅ **Safe to delete** - Field ini truly not used  
✅ **No code impact** - Zero referensi di codebase  
✅ **Reversible** - Ada backup untuk restore  
✅ **No performance impact** - Small tables anyway  

---

Dokumentasi dibuat: April 6, 2026  
Status: Ready for implementation  
Risk Level: **VERY LOW**
