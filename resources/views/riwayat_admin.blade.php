@include('header')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <title>Riwayat Transaksi - Admin</title>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(145deg, #e9eef3 0%, #dce2ea 100%);
            font-family: 'Inter', system-ui, sans-serif;
            padding: 1.5rem;
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
        }

        .white-dashboard {
            max-width: 1400px;
            width: 100%;
            margin: 2rem auto 0 auto;
            background: #ffffff;
            border-radius: 2rem;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.12);
            overflow: hidden;
        }

        .dashboard-inner {
            padding: 2rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #c90000;
            margin-bottom: 1.5rem;
            border-left: 4px solid #c90000;
            padding-left: 0.75rem;
        }

        /* Tab styles */
        .tab-container {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #eef2f8;
        }
        .tab-btn {
            background: none;
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            color: #5e6f8d;
            cursor: pointer;
            transition: 0.2s;
            position: relative;
        }
        .tab-btn.active {
            color: #c90000;
        }
        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #c90000;
        }
        .tab-btn:hover {
            color: #a50000;
        }

        /* Dua kolom 1/2 - 1/2 */
        .tables-row {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }
        .table-half {
            flex: 1;
            background: #fff;
            border-radius: 1rem;
            border: 1px solid #edf2f7;
            overflow-x: auto;
        }
        .table-header {
            font-weight: 600;
            font-size: 1.1rem;
            padding: 1rem;
            background: #f8fafd;
            border-bottom: 1px solid #eef2f8;
            color: #1e2f41;
        }
        .transaksi-table {
            width: 100%;
            border-collapse: collapse;
        }
        .transaksi-table th,
        .transaksi-table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #edf2f7;
        }
        .transaksi-table th {
            background: #f8fafd;
            font-weight: 600;
            color: #1e2f41;
            font-size: 0.85rem;
        }
        .transaksi-table td {
            color: #2c3e4e;
            font-size: 0.85rem;
        }
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .status-berhasil {
            background: #e8f5e9;
            color: #2e7d32;
        }
        .no-data {
            text-align: center;
            padding: 2rem;
            color: #8f9bb3;
        }

        /* Filter section */
        .filter-section {
            background: #f8fafd;
            border-radius: 1rem;
            padding: 1rem;
            margin-top: 1rem;
            border: 1px solid #eef2f8;
        }
        .filter-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: flex-end;
        }
        .filter-item {
            flex: 1;
            min-width: 150px;
        }
        .filter-item label {
            display: block;
            font-size: 0.75rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
            color: #5e6f8d;
        }
        .filter-item input, .filter-item select {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
        }
        .btn-reset {
            background: #c90000;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 40px;
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: 0.15s;
        }
        .btn-reset:hover {
            background: #a50000;
        }

        @media (max-width: 1000px) {
            .tables-row {
                flex-direction: column;
            }
        }
        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            .dashboard-inner {
                padding: 1rem;
            }
            .transaksi-table th,
            .transaksi-table td {
                padding: 0.5rem;
                font-size: 0.75rem;
            }
            .filter-group {
                flex-direction: column;
                align-items: stretch;
            }
            .filter-item {
                width: 100%;
            }
            .btn-reset {
                margin-top: 0.5rem;
            }
        }
    </style>
</head>
<body>
<div class="white-dashboard">
    <div class="dashboard-inner">
        <div class="page-title">Riwayat Transaksi - Semua User (Level 1)</div>

        <div class="tables-row">
            <!-- Tabel Transaksi Pulsa (kiri) -->
            <div class="table-half">
                <div class="table-header">Transaksi Pulsa</div>
                <table class="transaksi-table" id="pulsaTable">
                    <thead>
                         <tr>
                            <th>User</th>
                            <th>No HP</th>
                            <th>Tanggal</th>
                            <th>Nominal</th>
                            <th>Produk</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="pulsaTableBody">
                        @forelse($pulsaTransactions as $trans)
                        <tr data-tanggal="{{ \Carbon\Carbon::parse($trans->tanggal)->format('Y-m-d') }}"
                            data-nominal="{{ $trans->pulsa_masuk }}"
                            data-produk="{{ $trans->nama_pulsa ?? 'Pulsa ' . $trans->nominal_pulsa }}"
                            data-user="{{ $trans->user_nama }}"
                            data-nohp="{{ $trans->no_hp_user }}">
                            <td>{{ $trans->user_nama }}</td>
                            <td>{{ $trans->no_hp_user }}</td>
                            <td>{{ \Carbon\Carbon::parse($trans->tanggal)->format('d/m/Y H:i') }}</td>
                            <td>Rp{{ number_format($trans->pulsa_masuk, 0, ',', '.') }}</td>
                            <td>{{ $trans->nama_pulsa ?? 'Pulsa ' . $trans->nominal_pulsa }}</td>
                            <td><span class="status-badge status-berhasil">{{ ucfirst($trans->status) }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="no-data">Belum ada transaksi pulsa</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Tabel Transaksi Kuota (kanan) -->
            <div class="table-half">
                <div class="table-header">Transaksi Kuota</div>
                <table class="transaksi-table" id="kuotaTable">
                    <thead>
                         <tr>
                            <th>User</th>
                            <th>No HP</th>
                            <th>Tanggal</th>
                            <th>Kuota</th>
                            <th>Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="kuotaTableBody">
                        @forelse($kuotaTransactions as $trans)
                        <tr data-tanggal="{{ \Carbon\Carbon::parse($trans->tanggal)->format('Y-m-d') }}"
                            data-kuota="{{ $trans->kuota }}"
                            data-harga="{{ $trans->pulsa_keluar }}"
                            data-user="{{ $trans->user_nama }}"
                            data-nohp="{{ $trans->no_hp_user }}">
                            <td>{{ $trans->user_nama }}</td>
                            <td>{{ $trans->no_hp_user }}</td>
                            <td>{{ \Carbon\Carbon::parse($trans->tanggal)->format('d/m/Y H:i') }}</td>
                            <td>{{ $trans->kuota }}</td>
                            <td>Rp{{ number_format($trans->pulsa_keluar, 0, ',', '.') }}</td>
                            <td><span class="status-badge status-berhasil">{{ ucfirst($trans->status) }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="no-data">Belum ada transaksi kuota</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Filter Sidebar -->
        <div class="filter-section">
            <div class="filter-group">
                <div class="filter-item">
                    <label><i class="fas fa-user"></i> User</label>
                    <input type="text" id="filterUser" placeholder="Nama user">
                </div>
                <div class="filter-item">
                    <label><i class="fas fa-phone"></i> No HP</label>
                    <input type="text" id="filterNoHp" placeholder="No HP">
                </div>
                <div class="filter-item">
                    <label><i class="fas fa-calendar-alt"></i> Tanggal</label>
                    <input type="date" id="filterTanggal">
                </div>
                <div class="filter-item">
                    <label><i class="fas fa-money-bill-wave"></i> Nominal/Harga</label>
                    <input type="number" id="filterNominal" placeholder="Nominal pulsa / harga kuota">
                </div>
                <div class="filter-item">
                    <label><i class="fas fa-search"></i> Cari (Produk/Kuota)</label>
                    <input type="text" id="filterSearch" placeholder="Nama produk / kuota">
                </div>
                <div class="filter-item">
                    <button class="btn-reset" id="resetFilter"><i class="fas fa-undo-alt"></i> Reset</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        const filterUser = document.getElementById('filterUser');
        const filterNoHp = document.getElementById('filterNoHp');
        const filterTanggal = document.getElementById('filterTanggal');
        const filterNominal = document.getElementById('filterNominal');
        const filterSearch = document.getElementById('filterSearch');
        const resetBtn = document.getElementById('resetFilter');

        const pulsaRows = Array.from(document.querySelectorAll('#pulsaTableBody tr:not(.no-data)'));
        const kuotaRows = Array.from(document.querySelectorAll('#kuotaTableBody tr:not(.no-data)'));

        function filterTables() {
            const user = filterUser.value.trim().toLowerCase();
            const nohp = filterNoHp.value.trim().toLowerCase();
            const tanggal = filterTanggal.value;
            const nominal = filterNominal.value ? parseInt(filterNominal.value) : null;
            const search = filterSearch.value.trim().toLowerCase();

            // Filter pulsa
            let visiblePulsa = 0;
            pulsaRows.forEach(row => {
                let show = true;
                if (user) {
                    const rowUser = row.getAttribute('data-user').toLowerCase();
                    if (!rowUser.includes(user)) show = false;
                }
                if (nohp && show) {
                    const rowNohp = row.getAttribute('data-nohp').toLowerCase();
                    if (!rowNohp.includes(nohp)) show = false;
                }
                if (tanggal && show) {
                    const rowTanggal = row.getAttribute('data-tanggal');
                    if (rowTanggal !== tanggal) show = false;
                }
                if (nominal !== null && show) {
                    const rowNominal = parseInt(row.getAttribute('data-nominal'));
                    if (rowNominal !== nominal) show = false;
                }
                if (search && show) {
                    const produk = row.getAttribute('data-produk').toLowerCase();
                    if (!produk.includes(search)) show = false;
                }
                row.style.display = show ? '' : 'none';
                if (show) visiblePulsa++;
            });

            // Filter kuota
            let visibleKuota = 0;
            kuotaRows.forEach(row => {
                let show = true;
                if (user) {
                    const rowUser = row.getAttribute('data-user').toLowerCase();
                    if (!rowUser.includes(user)) show = false;
                }
                if (nohp && show) {
                    const rowNohp = row.getAttribute('data-nohp').toLowerCase();
                    if (!rowNohp.includes(nohp)) show = false;
                }
                if (tanggal && show) {
                    const rowTanggal = row.getAttribute('data-tanggal');
                    if (rowTanggal !== tanggal) show = false;
                }
                if (nominal !== null && show) {
                    const rowHarga = parseInt(row.getAttribute('data-harga'));
                    if (rowHarga !== nominal) show = false;
                }
                if (search && show) {
                    const kuota = row.getAttribute('data-kuota').toLowerCase();
                    if (!kuota.includes(search)) show = false;
                }
                row.style.display = show ? '' : 'none';
                if (show) visibleKuota++;
            });

            // Tampilkan pesan "tidak ada data" jika semua baris tersembunyi
            const pulsaTbody = document.getElementById('pulsaTableBody');
            const kuotaTbody = document.getElementById('kuotaTableBody');

            pulsaTbody.querySelectorAll('.no-data-row').forEach(el => el.remove());
            kuotaTbody.querySelectorAll('.no-data-row').forEach(el => el.remove());

            if (visiblePulsa === 0 && pulsaRows.length > 0) {
                const noDataRow = document.createElement('tr');
                noDataRow.className = 'no-data-row';
                noDataRow.innerHTML = '<td colspan="6" class="no-data">Tidak ada transaksi pulsa yang sesuai</td>';
                pulsaTbody.appendChild(noDataRow);
            }
            if (visibleKuota === 0 && kuotaRows.length > 0) {
                const noDataRow = document.createElement('tr');
                noDataRow.className = 'no-data-row';
                noDataRow.innerHTML = '<td colspan="6" class="no-data">Tidak ada transaksi kuota yang sesuai</td>';
                kuotaTbody.appendChild(noDataRow);
            }
        }

        function resetFilters() {
            filterUser.value = '';
            filterNoHp.value = '';
            filterTanggal.value = '';
            filterNominal.value = '';
            filterSearch.value = '';
            filterTables();
        }

        filterUser.addEventListener('input', filterTables);
        filterNoHp.addEventListener('input', filterTables);
        filterTanggal.addEventListener('change', filterTables);
        filterNominal.addEventListener('input', filterTables);
        filterSearch.addEventListener('input', filterTables);
        resetBtn.addEventListener('click', resetFilters);
    })();
</script>
</body>
</html>
@include('footer')