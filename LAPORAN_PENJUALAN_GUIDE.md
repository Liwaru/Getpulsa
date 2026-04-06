# Panduan Fitur Laporan Penjualan

## 📊 Deskripsi Fitur

Fitur **Laporan Penjualan** memberikan analisis mendalam tentang pendapatan dari penjualan pulsa dan kuota. User dapat melihat data penjualan dengan filter berdasarkan:
- **Tipe Laporan**: Pulsa atau Kuota
- **Periode Waktu**: Harian, Mingguan, Bulanan, Tahunan

---

## 🎯 Akses Fitur

### Siapa yang Bisa Akses
- **Superadmin (Level 3)** ✓ (dengan permission)
- **Owner/Admin Tingkat Tinggi** ✓

### Menu
- **Nama Menu**: Laporan Penjualan
- **Menu Key**: `laporan_penjualan`
- **URL**: `/laporan-penjualan`
- **Icon**: 📈 Graph Up

### Permintaan Permission
Menu ini dapat dimanage di halaman **Hak Akses** seperti fitur lainnya.

---

## 🎨 Tampilan Halaman

### 1. Header Section
```
📊 Laporan Penjualan
Analisis pendapatan dari penjualan pulsa dan kuota
```

### 2. Filter Section
Interface untuk memilih:
- **Tipe Laporan**: Dropdown (Pulsa / Kuota)
- **Periode**: Dropdown (Harian / Mingguan / Bulanan / Tahunan)

Filter otomatis berubah saat user memilih opsi.

### 3. Statistik Cards
Menampilkan 4 kartu statistik:
- **Total Transaksi**: Jumlah transaksi berhasil
- **Total Pendapatan**: Total revenue (Rp)
- **Rata-rata Transaksi**: Average per transaksi (Rp)
- **Periode**: Periode waktu yang dipilih

### 4. Grafik Penjualan
- **Tipe**: Bar Chart
- **Data**: Menampilkan trend penjualan per periode
- **Library**: Chart.js

### 5. Detail Per Periode
Tabel yang menunjukkan:
- Periode (Tanggal/Bulan/Hari/Jam)
- Jumlah transaksi
- Total revenue

### 6. Daftar Transaksi Lengkap
Tabel detail semua transaksi dengan kolom:
- ID Transaksi
- Nama Pelanggan
- Item (Nama paket)
- Harga
- Tanggal & Waktu
- Status

---

## 📋 Detail Implementasi

### Controller Methods

#### `laporanPenjualan(Request $request)`
Menampilkan halaman laporan penjualan dengan parameter:
- `period` (harian/mingguan/bulanan/tahunan)
- `type` (pulsa/kuota)

#### `getLaporanData($type, $period)`
Mengambil data penjualan dari database dengan:
- Filter berdasarkan tipe (pulsa/kuota)
- Filter berdasarkan periode waktu
- Joins dengan tabel pulsa/kuota/users
- Menghitung statistik (total, rata-rata)

#### `groupTransactionsByPeriod($transactions, $period)`
Helper untuk mengelompokkan transaksi berdasarkan periode:
- **Harian**: Per jam (00:00 - 23:00)
- **Mingguan**: Per hari dalam minggu (Monday-Sunday)
- **Bulanan**: Per tanggal
- **Tahunan**: Per bulan

### Database Queries

```php
// Mengambil transaksi sukses berdasarkan tipe
DB::table('transaksi')
    ->where('status', 'success')
    ->where('tipe_transaksi', $type) // pulsa atau kuota
    ->leftJoin('pulsa', ...)
    ->leftJoin('kuota', ...)
    ->leftJoin('users', ...)
    ->get();
```

---

## 🧪 Test Scenarios

### Scenario 1: Lihat Laporan Pulsa Harian
1. Login sebagai Superadmin
2. Klik menu "Laporan Penjualan"
3. Filter: Tipe = "Laporan Penjualan Pulsa", Periode = "Harian"
4. ✅ Muncul data penjualan pulsa untuk hari ini

**Verifikasi**:
- Statistik cards menampilkan data hari ini
- Chart menampilkan per jam
- Tabel detail menampilkan transaksi jam ini

### Scenario 2: Lihat Laporan Kuota Mingguan
1. Masih di halaman Laporan Penjualan
2. Filter: Tipe = "Laporan Penjualan Kuota", Periode = "Mingguan"
3. ✅ Muncul data penjualan kuota minggu ini

**Verifikasi**:
- Cards menampilkan statistik minggu ini
- Chart menampilkan per hari (Mon-Sun)
- Tabel detail per hari

### Scenario 3: Lihat Laporan Tahunan
1. Filter: Tipe = "Laporan Penjualan Pulsa", Periode = "Tahunan"
2. ✅ Muncul data penjualan tahun ini

**Verifikasi**:
- Chart menampilkan per bulan (12 bar)
- Tabel detail per bulan (Jan-Dec)

### Scenario 4: Tidak Ada Data
1. Jika belum ada transaksi untuk periode/tipe tertentu
2. ✅ Tampil pesan: "Tidak ada data penjualan untuk periode ini"

---

## 📊 Contoh Data Laporan

### Laporan Pulsa Harian
```
Total Transaksi: 25
Total Pendapatan: Rp 1.250.000
Rata-rata: Rp 50.000
Periode: harian

Per Jam:
08:00 - 5 transaksi - Rp 250.000
09:00 - 8 transaksi - Rp 400.000
10:00 - 7 transaksi - Rp 350.000
11:00 - 5 transaksi - Rp 250.000
```

### Laporan Kuota Mingguan
```
Total Transaksi: 142
Total Pendapatan: Rp 7.100.000
Rata-rata: Rp 50.000
Periode: mingguan

Per Hari:
Monday   - 18 transaksi - Rp 900.000
Tuesday  - 22 transaksi - Rp 1.100.000
Wednesday- 20 transaksi - Rp 1.000.000
Thursday - 25 transaksi - Rp 1.250.000
Friday   - 28 transaksi - Rp 1.400.000
Saturday - 19 transaksi - Rp 950.000
Sunday   - 10 transaksi - Rp 500.000
```

---

## 🔧 Konfigurasi

### Default Period
```php
$period = $request->get('period', 'bulanan'); // Default: Bulanan
```

### Default Type
```php
$type = $request->get('type', 'pulsa'); // Default: Pulsa
```

### Valid Options
- **Periods**: `harian`, `mingguan`, `bulanan`, `tahunan`
- **Types**: `pulsa`, `kuota`

---

## 📈 Fitur Chart

Menggunakan **Chart.js** versi 3.9.1 untuk menampilkan:
- **Bar Chart** untuk visualisasi penjualan per periode
- **Tooltip** untuk detail saat hover
- **Responsive** untuk semua ukuran layar
- **Formatting** currency otomatis (Rp format)

---

## 💾 Data Calculation

### Total Penjualan
```php
$totalPenjualan = count($transactions);
```

### Total Biaya
```php
$totalBiaya = $transactions->sum('total_biaya');
```

### Rata-rata Transaksi
```php
$rataRataBiaya = $totalPenjualan > 0 ? $totalBiaya / $totalPenjualan : 0;
```

---

## 🔄 Update Permissions

Menu ini sudah ditambah ke daftar yang bisa dimanage di `/hak-akses`:

**Tabel Management**:
```
Menu | Admin | Superadmin
-----|-------|--------
Laporan Penjualan | | ☑
```

**Default Permission**:
- Level 2 (Admin): ❌ Tidak ada akses
- Level 3 (Superadmin): ✅ Ada akses (bisa di-disable)

---

## ✨ Features

✅ **Dua Tipe Laporan**: Pulsa dan Kuota terpisah  
✅ **Empat Filter Periode**: Harian, Mingguan, Bulanan, Tahunan  
✅ **Statistik Lengkap**: Total, rata-rata, trend  
✅ **Visualisasi Chart**: Bar chart untuk trend  
✅ **Tabel Detail**: Semua transaksi dengan detail lengkap  
✅ **Responsive Design**: Mobile-friendly  
✅ **Currency Formatting**: Otomatis Rp format  
✅ **Permission Management**: Bisa di-enable/disable  

---

## 🚀 Cara Menambah Fitur Laporan Lain

Jika ingin menambah laporan baru (mis: Laporan Refund, Laporan Top Products):

1. **Update hakAkses()** di Controller
```php
$menus = [
    // ... menu lama ...
    'laporan_refund',      // Menu baru
    'laporan_top_produk',  // Menu baru
];
```

2. **Buat method baru** di Controller
```php
public function laporanRefund(Request $request) {
    // Logic laporan refund
}

public function laporanTopProduk(Request $request) {
    // Logic laporan top produk
}
```

3. **Add routes** di web.php
```php
Route::get('/laporan-refund', [Control::class, 'laporanRefund'])
    ->name('laporan.refund');
```

4. **Add menu** di header.blade.php
```blade
@if($hasPermission('laporan_refund'))
<li>
    <a href="/laporan-refund">
        <i class="bi bi-graph-down"></i> Laporan Refund
    </a>
</li>
@endif
```

5. **Update default permissions** di database

---

## ⚠️ Catatan Penting

- **Status Filter**: Hanya menampilkan transaksi dengan status 'success'
- **Currency**: Format Rupiah (Rp) otomatis dengan separator ribuan
- **Timezone**: Menggunakan timezone server
- **Chart**: Require JavaScript enabled
- **Data Besar**: Jika data sangat besar, pertimbangkan pagination

---

## 🆘 Troubleshooting

### Chart tidak muncul
**Solusi**: 
- Pastikan Chart.js sudah ter-load dari CDN
- Cek browser console untuk error JavaScript
- Verifikasi ada data untuk period/type tersebut

### Tanggal tidak sesuai timezone
**Solusi**:
- Pastikan `.env` timezone sesuai: `APP_TIMEZONE=Asia/Jakarta`
- Check database untuk created_at values

### Statistik tidak akurat
**Solusi**:
- Clear browser cache
- Verifikasi data status transaksi di database (harus 'success')

---

Created: April 6, 2026
