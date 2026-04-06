@include('header')

<style>
    body {
        margin: 0 !important;
        padding: 0 !important;
    }

    .laporan-container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .laporan-header {
        background: linear-gradient(135deg, #eb0000 0%, #bd0000 100%);
        color: white;
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .laporan-header h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
    }

    .laporan-header p {
        margin: 10px 0 0 0;
        opacity: 0.9;
        font-size: 1rem;
    }

    .filter-section {
        background: white;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-group {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .filter-group label {
        font-weight: 600;
        color: #333;
        min-width: 80px;
    }

    .filter-group select,
    .filter-group input {
        padding: 8px 12px;
        border: 2px solid #e0e0e0;
        border-radius: 6px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .filter-group select:focus,
    .filter-group input:focus {
        outline: none;
        border-color: #eb0000;
        box-shadow: 0 0 0 3px rgba(235, 0, 0, 0.1);
    }

    .btn-filter {
        padding: 8px 20px;
        background: #eb0000;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-filter:hover {
        background: #bd0000;
        box-shadow: 0 4px 12px rgba(235, 0, 0, 0.3);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        border-left: 4px solid #eb0000;
    }

    .stat-label {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 10px;
        text-transform: uppercase;
        font-weight: 600;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #eb0000;
    }

    .laporan-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    @media (max-width: 1000px) {
        .laporan-content {
            grid-template-columns: 1fr;
        }
    }

    .card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .card-header {
        font-size: 1.1rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e0e0e0;
    }

    .chart-container {
        position: relative;
        height: 300px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th {
        background: #f5f5f5;
        padding: 12px;
        text-align: left;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #e0e0e0;
    }

    .table td {
        padding: 12px;
        border-bottom: 1px solid #e0e0e0;
    }

    .table tr:hover {
        background: #f9f9f9;
    }

    .table.table-striped tbody tr:nth-child(even) {
        background: #f9f9f9;
    }

    .badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .text-right {
        text-align: right;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .tab-buttons {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .tab-btn {
        flex: 1;
        padding: 12px 20px;
        border: 2px solid #e0e0e0;
        background: white;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #666;
    }

    .tab-btn.active {
        border-color: #eb0000;
        background: #eb0000;
        color: white;
    }

    .tab-btn:hover {
        border-color: #eb0000;
    }

    .currency {
        font-family: 'Courier New', monospace;
        white-space: nowrap;
    }

    @media print {
        .filter-section,
        .btn-filter,
        body::before {
            display: none;
        }

        .laporan-container {
            max-width: 100%;
            padding: 0;
        }

        .card {
            break-inside: avoid;
            page-break-inside: avoid;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<div class="content-area">
    <div class="laporan-container">
        <!-- Header -->
        <div class="laporan-header">
            <h1><i class="bi bi-graph-up"></i> Laporan Penjualan</h1>
            <p>Analisis pendapatan dari penjualan pulsa dan kuota</p>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <form method="GET" action="{{ route('laporan.penjualan') }}" style="display: flex; gap: 15px; width: 100%; flex-wrap: wrap;">
                <div class="filter-group">
                    <label for="type">Tipe Laporan:</label>
                    <select name="type" id="type" onchange="this.form.submit()">
                        <option value="pulsa" {{ $type === 'pulsa' ? 'selected' : '' }}>Laporan Penjualan Pulsa</option>
                        <option value="kuota" {{ $type === 'kuota' ? 'selected' : '' }}>Laporan Penjualan Kuota</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="period">Periode:</label>
                    <select name="period" id="period" onchange="this.form.submit()">
                        <option value="harian" {{ $period === 'harian' ? 'selected' : '' }}>Harian</option>
                        <option value="mingguan" {{ $period === 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                        <option value="bulanan" {{ $period === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                        <option value="tahunan" {{ $period === 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Transaksi</div>
                <div class="stat-value">{{ $laporan['totalPenjualan'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-value currency">Rp {{ number_format($laporan['totalBiaya'], 0, ',', '.') }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Rata-rata Transaksi</div>
                <div class="stat-value currency">Rp {{ number_format($laporan['rataRataBiaya'], 0, ',', '.') }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Periode</div>
                <div class="stat-value" style="font-size: 1.2rem; text-transform: capitalize;">{{ $period }}</div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="laporan-content">
            <!-- Chart -->
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-bar-chart"></i> Grafik Penjualan
                </div>
                <div class="chart-container">
                    @if(count($laporan['chartData']) > 0)
                        <canvas id="penjualanChart"></canvas>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">📊</div>
                            <p>Tidak ada data penjualan untuk periode ini</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statistics by Period -->
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-list-ul"></i> Detail Per Periode
                </div>
                <div class="table-responsive">
                    @if(count($laporan['chartData']) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Jumlah</th>
                                    <th class="text-right">Total (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($laporan['chartData'] as $data)
                                <tr>
                                    <td><strong>{{ $data['label'] }}</strong></td>
                                    <td><span class="badge badge-success">{{ $data['count'] }}</span></td>
                                    <td class="text-right currency">Rp {{ number_format($data['total'], 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <p>Tidak ada transaksi untuk ditampilkan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Transaction Details -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-receipt"></i> Daftar Transaksi Lengkap
            </div>
            <div class="table-responsive">
                @if(count($laporan['transactions']) > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID Transaksi</th>
                                <th>Pelanggan</th>
                                <th>Item</th>
                                <th>Harga</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporan['transactions'] as $transaction)
                            <tr>
                                <td><code style="font-size: 0.85rem;">{{ substr($transaction->id_transaksi, 0, 12) }}...</code></td>
                                <td>{{ $transaction->nama ?? 'N/A' }}</td>
                                <td>{{ $transaction->item_name ?? 'N/A' }}</td>
                                <td class="text-right currency">Rp {{ number_format($transaction->total_biaya, 0, ',', '.') }}</td>
                                <td>
                                    <small>
                                        {{ \Carbon\Carbon::parse($transaction->tanggal)->format('d/m/Y H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge badge-success">
                                        <i class="bi bi-check-circle"></i> {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">📋</div>
                        <p>Tidak ada transaksi ditemukan untuk periode dan tipe ini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart data dari controller
        const chartData = {!! json_encode($laporan['chartData']) !!};

        if (chartData && chartData.length > 0) {
            const ctx = document.getElementById('penjualanChart');
            
            if (ctx) {
                const labels = chartData.map(d => d.label);
                const data = chartData.map(d => d.total);

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Penjualan (Rp)',
                            data: data,
                            backgroundColor: 'rgba(235, 0, 0, 0.7)',
                            borderColor: 'rgba(235, 0, 0, 1)',
                            borderWidth: 2,
                            borderRadius: 8,
                            hoverBackgroundColor: 'rgba(189, 0, 0, 0.8)',
                            tension: 0.4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }
    });
</script>

@include('footer')
