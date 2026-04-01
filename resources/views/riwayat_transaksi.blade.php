@include('header')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <title>Riwayat Transaksi</title>
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

        /* Table styles */
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
        }

        .filter-bar {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.filter-bar input {
    padding: 0.4rem 0.6rem;
    border-radius: 0.5rem;
    border: 1px solid #d0d7e2;
    font-size: 0.85rem;
}

.filter-bar button {
    padding: 0.4rem 0.75rem;
    border: none;
    border-radius: 0.5rem;
    cursor: pointer;
    font-size: 0.85rem;
    font-weight: 500;
}

.btn-search {
    background: #c90000;
    color: white;
}

.btn-reset {
    background: #e5e9f2;
}

    </style>
</head>
<body>
<div class="white-dashboard">
    <div class="dashboard-inner">
        <div class="page-title">Riwayat Transaksi</div>

        <!-- Tab buttons -->
        <div class="tab-container">
            <button class="tab-btn active" id="tabPulsa">Transaksi Pulsa</button>
            <button class="tab-btn" id="tabKuota">Transaksi Kuota</button>
        </div>

        <!-- Tabel Transaksi Pulsa -->
        <div id="pulsaContainer">
            <table class="transaksi-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nominal</th>
                        <th>Produk</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pulsaTransactions as $trans)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($trans->tanggal)->format('d/m/Y H:i') }}</td>
                            <td>Rp{{ number_format($trans->pulsa_masuk, 0, ',', '.') }}</td>
                            <td>{{ $trans->nama_pulsa ?? 'Pulsa ' . $trans->nominal_pulsa }}</td>
                            <td><span class="status-badge status-berhasil">{{ ucfirst($trans->status) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="no-data">Belum ada transaksi pulsa</td>
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
                        <th>Kuota</th>
                        <th>Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kuotaTransactions as $trans)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($trans->tanggal)->format('d/m/Y H:i') }}</td>
                            <td>{{ $trans->kuota }}</td>
                            <td>Rp{{ number_format($trans->pulsa_keluar, 0, ',', '.') }}</td>
                            <td><span class="status-badge status-berhasil">{{ ucfirst($trans->status) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="no-data">Belum ada transaksi kuota</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Tab switching logic
    const tabPulsa = document.getElementById('tabPulsa');
    const tabKuota = document.getElementById('tabKuota');
    const pulsaContainer = document.getElementById('pulsaContainer');
    const kuotaContainer = document.getElementById('kuotaContainer');

    tabPulsa.addEventListener('click', () => {
        tabPulsa.classList.add('active');
        tabKuota.classList.remove('active');
        pulsaContainer.style.display = 'block';
        kuotaContainer.style.display = 'none';
    });

    tabKuota.addEventListener('click', () => {
        tabKuota.classList.add('active');
        tabPulsa.classList.remove('active');
        pulsaContainer.style.display = 'none';
        kuotaContainer.style.display = 'block';
    });
</script>
</body>
</html>
@include('footer')