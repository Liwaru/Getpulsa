@include('header')

<style>
    body {
        margin: 0 !important;
        padding: 0 !important;
    }

    .statistik-container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .statistik-header {
        background: linear-gradient(135deg, #eb0000 0%, #bd0000 100%);
        color: white;
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .statistik-header h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
    }

    .statistik-header p {
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
        min-width: 100px;
    }

    .filter-group select {
        padding: 8px 12px;
        border: 2px solid #e0e0e0;
        border-radius: 6px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .filter-group select:focus {
        outline: none;
        border-color: #eb0000;
        box-shadow: 0 0 0 3px rgba(235, 0, 0, 0.1);
    }

    .stats-overview {
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
        text-align: center;
    }

    .stat-label {
        color: #666;
        font-size: 0.85rem;
        margin-bottom: 10px;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #eb0000;
        margin: 5px 0;
    }

    .stat-subtitle {
        color: #999;
        font-size: 0.85rem;
        margin-top: 5px;
    }

    .produk-table {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    @media (min-width: 769px) {
        .statistik-container {
            max-width: min(1200px, calc(100vw - 280px - 3rem));
        }
    }

    .table-header {
        background: #f8f9fa;
        padding: 20px;
        border-bottom: 2px solid #e0e0e0;
    }

    .table-header h2 {
        margin: 0;
        font-size: 1.3rem;
        color: #333;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .table th {
        background: #f8f9fa;
        padding: 15px 20px;
        text-align: left;
        font-weight: 700;
        color: #333;
        border-bottom: 2px solid #eb0000;
        white-space: nowrap;
    }

    .table td {
        padding: 15px 20px;
        border-bottom: 1px solid #e0e0e0;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: #f8f9fa;
        transition: background 0.2s ease;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .nama-produk {
        font-weight: 600;
        color: #333;
    }

    .tipe-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-pulsa {
        background: rgba(235, 0, 0, 0.2);
        color: #eb0000;
    }

    .badge-kuota {
        background: rgba(52, 152, 219, 0.2);
        color: #3498db;
    }

    .currency {
        font-family: 'Courier New', monospace;
        font-weight: 600;
        color: #27ae60;
    }

    .number-high {
        font-weight: 700;
        color: #eb0000;
    }

    .success-rate {
        display: inline-block;
        padding: 4px 8px;
        background: #d4edda;
        color: #155724;
        border-radius: 4px;
        font-weight: 600;
    }

    .empty-state {
        padding: 40px 20px;
        text-align: center;
        color: #999;
    }

    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 15px;
    }

    .empty-state p {
        margin: 0;
        font-size: 1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .statistik-container {
            padding: 15px;
        }

        .statistik-header h1 {
            font-size: 1.5rem;
        }

        .stats-overview {
            grid-template-columns: 1fr;
        }

        .filter-section {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-group {
            flex-direction: column;
            align-items: flex-start;
        }

        .filter-group select {
            width: 100%;
        }

        .table {
            font-size: 0.9rem;
        }

        .table th,
        .table td {
            padding: 10px;
        }

        .stat-value {
            font-size: 1.5rem;
        }
    }
</style>

<div class="content-area">
    <div class="statistik-container">
        <!-- Header -->
        <div class="statistik-header">
            <h1><i class="bi bi-graph-up"></i> Statistik Produk</h1>
            <p>Analisis penjualan dan performa produk pulsa dan kuota</p>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <form method="GET" action="{{ route('statistik.produk') }}" style="display: flex; gap: 15px; width: 100%; flex-wrap: wrap; align-items: center;">
                <div class="filter-group">
                    <label for="tipe">Pilih Statistik:</label>
                    <select name="tipe" id="tipe" onchange="this.form.submit()">
                        <option value="pulsa" {{ $tipe === 'pulsa' ? 'selected' : '' }}> Statistik Produk Pulsa</option>
                        <option value="kuota" {{ $tipe === 'kuota' ? 'selected' : '' }}> Statistik Produk Kuota</option>
                        <option value="best-seller" {{ $tipe === 'best-seller' ? 'selected' : '' }}> Produk Paling Laku (Top 10)</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Statistics Overview Cards -->
        <div class="stats-overview">
            <div class="stat-card">
                <div class="stat-label">Total Produk</div>
                <div class="stat-value">{{ $statistik['total_produk'] }}</div>
                <div class="stat-subtitle">jenis produk</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Penjualan</div>
                <div class="stat-value number-high">{{ number_format($statistik['total_terjual'], 0, ',', '.') }}</div>
                <div class="stat-subtitle">transaksi</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Penjualan Berhasil</div>
                <div class="stat-value" style="color: #27ae60;">{{ number_format($statistik['total_berhasil'], 0, ',', '.') }}</div>
                <div class="stat-subtitle">
                    @if($statistik['total_terjual'] > 0)
                        <span class="success-rate">{{ round(($statistik['total_berhasil'] / $statistik['total_terjual']) * 100, 1) }}% sukses</span>
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Revenue</div>
                <div class="stat-value currency">Rp {{ number_format($statistik['total_revenue'], 0, ',', '.') }}</div>
                <div class="stat-subtitle">total pendapatan</div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="produk-table">
            <div class="table-header">
                <h2>
                    @if($tipe === 'pulsa')
                        <i class="bi bi-phone"></i> Daftar Produk Pulsa
                    @elseif($tipe === 'kuota')
                        <i class="bi bi-wifi"></i> Daftar Produk Kuota
                    @else
                        <i class="bi bi-star"></i> Top 10 Produk Paling Laku
                    @endif
                </h2>
            </div>

            <div class="table-responsive">
                @if($statistik['produk']->count() > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 30%;">Nama Produk</th>
                                @if($tipe === 'best-seller')
                                    <th>Tipe</th>
                                @endif
                                <th style="text-align: right;">Harga</th>
                                <th style="text-align: center;">Total Terjual</th>
                                <th style="text-align: center;">Berhasil</th>
                                <th style="text-align: right;">Total Revenue</th>
                                <th style="text-align: center;">Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statistik['produk'] as $produk)
                            <tr>
                                <td>
                                    <span class="nama-produk">
                                        @if($tipe === 'best-seller' && $produk->tipe_produk === 'pulsa')
                                            📱
                                        @elseif($tipe === 'best-seller' && $produk->tipe_produk === 'kuota')
                                            📡
                                        @endif
                                        {{ $produk->nama_produk ?? $produk->pulsa ?? $produk->kuota }}
                                    </span>
                                </td>
                                @if($tipe === 'best-seller')
                                    <td>
                                        <span class="tipe-badge {{ $produk->tipe_produk === 'pulsa' ? 'badge-pulsa' : 'badge-kuota' }}">
                                            {{ ucfirst($produk->tipe_produk) }}
                                        </span>
                                    </td>
                                @endif
                                <td style="text-align: right;">
                                    <span class="currency">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                                </td>
                                <td style="text-align: center;">
                                    <span class="number-high">{{ $produk->total_terjual }}</span>
                                </td>
                                <td style="text-align: center;">
                                    @if($produk->total_terjual > 0)
                                        <span class="success-rate">
                                            {{ $produk->total_berhasil }} / {{ $produk->total_terjual }}
                                            <br>
                                            <small>{{ round(($produk->total_berhasil / $produk->total_terjual) * 100, 1) }}%</small>
                                        </span>
                                    @else
                                        <span style="color: #999;">-</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <span class="currency">Rp {{ number_format($produk->total_revenue, 0, ',', '.') }}</span>
                                </td>
                                <td style="text-align: center;">
                                    @if($produk->total_terjual > 0)
                                        @if($produk->total_revenue > 1000000)
                                            <span style="font-size: 1.2rem;">⭐⭐⭐⭐⭐</span>
                                        @elseif($produk->total_revenue > 500000)
                                            <span style="font-size: 1.2rem;">⭐⭐⭐⭐</span>
                                        @elseif($produk->total_revenue > 250000)
                                            <span style="font-size: 1.2rem;">⭐⭐⭐</span>
                                        @elseif($produk->total_revenue > 100000)
                                            <span style="font-size: 1.2rem;">⭐⭐</span>
                                        @else
                                            <span style="font-size: 1.2rem;">⭐</span>
                                        @endif
                                    @else
                                        <span style="color: #999;">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">📦</div>
                        <p>Belum ada data produk atau transaksi untuk ditampilkan</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Daftar Transaksi Lengkap -->
        <div class="produk-table" style="margin-top: 30px;">
            <div class="table-header">
                <h2>
                    <i class="bi bi-receipt"></i> Daftar Transaksi Lengkap
                </h2>
            </div>

            <div class="table-responsive">
                @if($transaksi->count() > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 12%;">Tanggal</th>
                                <th style="width: 15%;">User</th>
                                <th style="width: 18%;">Produk</th>
                                <th style="text-align: right; width: 12%;">Harga</th>
                                <th style="text-align: center; width: 12%;">Status</th>
                                <th style="width: 15%;">Metode Pembayaran</th>
                                <th style="text-align: center; width: 16%;">Channel</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi as $trans)
                            <tr>
                                <td>
                                    <small>
                                        {{ \Carbon\Carbon::parse($trans->tanggal)->format('d/m/Y H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $trans->nama ?? '-' }}</strong>
                                        <br>
                                        <small style="color: #999;">{{ $trans->no_hp_user ?? '-' }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        @if($trans->pulsa)
                                            <span style="display: inline-block; margin-bottom: 3px;">
                                                <span class="badge-pulsa" style="padding: 2px 8px; border-radius: 4px; font-size: 0.75rem;"> Pulsa</span>
                                            </span>
                                            <br>
                                            <strong>{{ $trans->pulsa }}</strong>
                                        @elseif($trans->kuota)
                                            <span style="display: inline-block; margin-bottom: 3px;">
                                                <span class="badge-kuota" style="padding: 2px 8px; border-radius: 4px; font-size: 0.75rem;"> Kuota</span>
                                            </span>
                                            <br>
                                            <strong>{{ $trans->kuota }}</strong>
                                        @else
                                            <span style="color: #999;">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td style="text-align: right;">
                                    <span class="currency">
                                        @if($trans->harga)
                                            Rp {{ number_format($trans->harga, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    @if($trans->status === 'berhasil')
                                        <span class="success-rate" style="background: #d4edda;">
                                            <i class="bi bi-check-circle"></i> Berhasil
                                        </span>
                                    @elseif($trans->status === 'diproses')
                                        <span style="padding: 4px 8px; background: #fff3cd; color: #856404; border-radius: 4px; font-weight: 600; font-size: 0.8rem;">
                                            <i class="bi bi-hourglass-split"></i> Diproses
                                        </span>
                                    @elseif($trans->status === 'gagal')
                                        <span style="padding: 4px 8px; background: #f8d7da; color: #721c24; border-radius: 4px; font-weight: 600; font-size: 0.8rem;">
                                            <i class="bi bi-x-circle"></i> Gagal
                                        </span>
                                    @else
                                        <span style="color: #999;">{{ $trans->status ?? '-' }}</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <small>
                                        @if($trans->payment_method)
                                            {{ ucfirst(str_replace('_', ' ', $trans->payment_method)) }}
                                        @else
                                            <span style="color: #999;">-</span>
                                        @endif
                                    </small>
                                </td>
                                <td style="text-align: center;">
                                    <small>
                                        @if($trans->payment_channel)
                                            <span style="background: #e8f4f8; padding: 4px 8px; border-radius: 4px; display: inline-block;">
                                                {{ ucfirst($trans->payment_channel) }}
                                            </span>
                                        @else
                                            <span style="color: #999;">-</span>
                                        @endif
                                    </small>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">📋</div>
                        <p>Belum ada transaksi yang tercatat</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@include('footer')
