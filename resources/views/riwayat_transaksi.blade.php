@include('header')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <title>Riwayat Transaksi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            max-width: 1000px;
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

        .tab-container {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #eef2f8;
            width: 100%;
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

        .transaksi-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
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
        }

        .transaksi-table td {
            color: #2c3e4e;
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

        .method-badge {
            display: inline-block;
            padding: 0.2rem 0.65rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            background: #eef2f8;
            color: #1e2f41;
        }

        .no-data {
            text-align: center;
            padding: 2rem;
            color: #8f9bb3;
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
                font-size: 0.85rem;
            }
            .tab-btn {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
            .filter-bar {
                width: 100%;
                justify-content: flex-start;
                margin-left: 0;
                padding-bottom: 0.75rem;
                flex-wrap: wrap;
            }
        }

        .filter-bar {
            display: flex;
            justify-content: flex-end;
            gap: 0.35rem;
            flex-wrap: nowrap;
            align-items: center;
            margin-left: auto;
            padding-bottom: 0.75rem;
        }

        .filter-bar input {
            padding: 0.4rem 0.52rem;
            border-radius: 0.5rem;
            border: 1px solid #d0d7e2;
            font-size: 0.77rem;
            background: #fff;
            height: 31px;
        }

        #filterTanggalKuota,
        #filterTanggalPulsa {
            width: 122px;
        }

        #filterNominalKuota,
        #filterNominalPulsa {
            width: 72px;
        }
        #filterNamaPulsa,
        #filterNamaKuota {
            width: 100px;
        }

        #filterNoHpPulsa,
        #filterNoHpKuota {
            width: 100px;
        }
        .filter-bar button {
            padding: 0.4rem 0.7rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.77rem;
            font-weight: 600;
            height: 31px;
            min-width: 68px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .btn-search {
            background: #c90000;
            color: white;
        }

        .btn-reset {
            background: #e5e9f2;
            color: #23374d;
        }
    </style>
</head>
<body>
<div class="white-dashboard">
    <div class="dashboard-inner">
        <div class="page-title">Riwayat Transaksi</div>

        <div class="tab-container">
            <button class="tab-btn active" id="tabPulsa">Transaksi Pulsa</button>
            <button class="tab-btn" id="tabKuota">Transaksi Kuota</button>
            <div class="filter-bar" id="pulsaFilterBar">
                <input type="date" id="filterTanggalPulsa" placeholder="Tanggal">
                <input type="text" id="filterNamaPulsa" placeholder="Nama">
                <input type="text" id="filterNoHpPulsa" placeholder="No HP">
                <input type="text" id="filterNominalPulsa" placeholder="Nominal">
                <button type="button" class="btn-search" id="searchPulsaBtn">Search</button>
                <button type="button" class="btn-reset" id="resetPulsaBtn">Reset</button>
            </div>
            <div class="filter-bar" id="kuotaFilterBar" style="display: none;">
                <input type="date" id="filterTanggalKuota" placeholder="Tanggal">
                <input type="text" id="filterNamaKuota" placeholder="Nama">
                <input type="text" id="filterNoHpKuota" placeholder="No HP">
                <input type="text" id="filterNominalKuota" placeholder="Nominal">
                <button type="button" class="btn-search" id="searchKuotaBtn">Search</button>
                <button type="button" class="btn-reset" id="resetKuotaBtn">Reset</button>
            </div>
        </div>

        <!-- Tabel Transaksi Pulsa -->
        <div id="pulsaContainer">
            <table class="transaksi-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>Nominal</th>
                        <th>Metode</th>
                        <th>Produk</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pulsaTransactions as $trans)
                        <tr
                            data-tanggal="{{ \Carbon\Carbon::parse($trans->tanggal)->format('Y-m-d') }}"
                            data-nama="{{ strtolower($trans->user_nama ?? session('nama') ?? '-') }}"
                            data-nohp="{{ strtolower($trans->user_no_hp ?? $trans->no_hp_user ?? session('no_hp_user') ?? '-') }}"
                            data-nominal="{{ $trans->pulsa_masuk }}"
                        >
                            <td>{{ \Carbon\Carbon::parse($trans->tanggal)->format('d/m/Y H:i') }}</td>
                            <td>{{ $trans->user_nama ?? session('nama') ?? '-' }}</td>
                            <td>{{ $trans->user_no_hp ?? $trans->no_hp_user ?? session('no_hp_user') ?? '-' }}</td>
                            <td>Rp{{ number_format($trans->pulsa_masuk, 0, ',', '.') }}</td>
                            <td>
                                @if($trans->payment_channel)
                                    <span class="method-badge">{{ ucfirst($trans->payment_channel) }}</span>
                                @else
                                    <span style="color:#8f9bb3;">-</span>
                                @endif
                            </td>
                            <td>{{ $trans->nama_pulsa ?? 'Pulsa ' . $trans->nominal_pulsa }}</td>
                            <td><span class="status-badge status-berhasil">{{ ucfirst($trans->status) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="no-data">Belum ada transaksi pulsa</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tabel Transaksi Kuota -->
        <div id="kuotaContainer" style="display: none;">
            <table class="transaksi-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>Nominal</th>
                        <th>Metode</th>
                        <th>Produk</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kuotaTransactions as $trans)
                        <tr
                            data-tanggal="{{ \Carbon\Carbon::parse($trans->tanggal)->format('Y-m-d') }}"
                            data-nama="{{ strtolower($trans->user_nama ?? session('nama') ?? '-') }}"
                            data-nohp="{{ strtolower($trans->user_no_hp ?? $trans->no_hp_user ?? session('no_hp_user') ?? '-') }}"
                            data-nominal="{{ $trans->pulsa_keluar }}"
                        >
                            <td>{{ \Carbon\Carbon::parse($trans->tanggal)->format('d/m/Y H:i') }}</td>
                            <td>{{ $trans->user_nama ?? session('nama') ?? '-' }}</td>
                            <td>{{ $trans->user_no_hp ?? $trans->no_hp_user ?? session('no_hp_user') ?? '-' }}</td>
                            <td>Rp{{ number_format($trans->pulsa_keluar, 0, ',', '.') }}</td>
                            <td>
                                @if($trans->payment_channel)
                                    <span class="method-badge">{{ ucfirst($trans->payment_channel) }}</span>
                                @else
                                    <span style="color:#8f9bb3;">-</span>
                                @endif
                            </td>
                            <td>{{ $trans->nama_kuota ?? 'Paket Data ' . $trans->kuota }}</td>
                            <td><span class="status-badge status-berhasil">{{ ucfirst($trans->status) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="no-data">Belum ada transaksi kuota</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const tabPulsa = document.getElementById('tabPulsa');
    const tabKuota = document.getElementById('tabKuota');
    const pulsaContainer = document.getElementById('pulsaContainer');
    const kuotaContainer = document.getElementById('kuotaContainer');
    const pulsaFilterBar = document.getElementById('pulsaFilterBar');
    const kuotaFilterBar = document.getElementById('kuotaFilterBar');
    const filterTanggalPulsa = document.getElementById('filterTanggalPulsa');
    const filterNamaPulsa = document.getElementById('filterNamaPulsa');
    const filterNoHpPulsa = document.getElementById('filterNoHpPulsa');
    const filterNominalPulsa = document.getElementById('filterNominalPulsa');
    const searchPulsaBtn = document.getElementById('searchPulsaBtn');
    const resetPulsaBtn = document.getElementById('resetPulsaBtn');
    const filterTanggalKuota = document.getElementById('filterTanggalKuota');
    const filterNamaKuota = document.getElementById('filterNamaKuota');
    const filterNoHpKuota = document.getElementById('filterNoHpKuota');
    const filterNominalKuota = document.getElementById('filterNominalKuota');
    const searchKuotaBtn = document.getElementById('searchKuotaBtn');
    const resetKuotaBtn = document.getElementById('resetKuotaBtn');
    const pulsaRows = document.querySelectorAll('#pulsaContainer tbody tr[data-tanggal]');
    const kuotaRows = document.querySelectorAll('#kuotaContainer tbody tr[data-tanggal]');

    tabPulsa.addEventListener('click', () => {
        tabPulsa.classList.add('active');
        tabKuota.classList.remove('active');
        pulsaContainer.style.display = 'block';
        kuotaContainer.style.display = 'none';
        pulsaFilterBar.style.display = 'flex';
        kuotaFilterBar.style.display = 'none';
    });

    tabKuota.addEventListener('click', () => {
        tabKuota.classList.add('active');
        tabPulsa.classList.remove('active');
        pulsaContainer.style.display = 'none';
        kuotaContainer.style.display = 'block';
        pulsaFilterBar.style.display = 'none';
        kuotaFilterBar.style.display = 'flex';
    });

    function normalizeNominal(value) {
        return value.replace(/[^\d]/g, '');
    }

    function filterPulsaRows() {
        const tanggal = filterTanggalPulsa.value.trim();
        const nama = filterNamaPulsa.value.trim().toLowerCase();
        const nohp = filterNoHpPulsa.value.trim().toLowerCase();
        const nominal = normalizeNominal(filterNominalPulsa.value.trim());
        pulsaRows.forEach((row) => {
            const matchTanggal = !tanggal || row.dataset.tanggal === tanggal;
            const matchNama = !nama || row.dataset.nama.includes(nama);
            const matchNohp = !nohp || row.dataset.nohp.includes(nohp);
            const matchNominal = !nominal || row.dataset.nominal.includes(nominal);
            row.style.display = matchTanggal && matchNama && matchNohp && matchNominal ? '' : 'none';
        });
    }

    function filterKuotaRows() {
        const tanggal = filterTanggalKuota.value.trim();
        const nama = filterNamaKuota.value.trim().toLowerCase();
        const nohp = filterNoHpKuota.value.trim().toLowerCase();
        const nominal = normalizeNominal(filterNominalKuota.value.trim());
        kuotaRows.forEach((row) => {
            const matchTanggal = !tanggal || row.dataset.tanggal === tanggal;
            const matchNama = !nama || row.dataset.nama.includes(nama);
            const matchNohp = !nohp || row.dataset.nohp.includes(nohp);
            const matchNominal = !nominal || row.dataset.nominal.includes(nominal);
            row.style.display = matchTanggal && matchNama && matchNohp && matchNominal ? '' : 'none';
        });
    }

    function resetPulsaFilters() {
        filterTanggalPulsa.value = '';
        filterNamaPulsa.value = '';
        filterNoHpPulsa.value = '';
        filterNominalPulsa.value = '';
        pulsaRows.forEach((row) => { row.style.display = ''; });
    }

    function resetKuotaFilters() {
        filterTanggalKuota.value = '';
        filterNamaKuota.value = '';
        filterNoHpKuota.value = '';
        filterNominalKuota.value = '';
        kuotaRows.forEach((row) => { row.style.display = ''; });
    }

    searchPulsaBtn.addEventListener('click', filterPulsaRows);
    resetPulsaBtn.addEventListener('click', resetPulsaFilters);
    searchKuotaBtn.addEventListener('click', filterKuotaRows);
    resetKuotaBtn.addEventListener('click', resetKuotaFilters);
</script>
</body>
</html>
@include('footer')