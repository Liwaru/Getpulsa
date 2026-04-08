@include('header')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <title>Paket Data</title>
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
            padding-left: calc(280px + 1.5rem);
        }

        .white-dashboard {
            max-width: 1200px;
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

        .phone-header {
            background: #f8fafd;
            border-radius: 1.5rem;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid #eef2f8;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .phone-number {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1rem;
            font-weight: 500;
            color: #1e2f41;
        }

        .phone-number i {
            font-size: 1.3rem;
            color: #c90000;
        }

        .filter-group {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            background: #c90000;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.9rem;
            color: white;
            cursor: pointer;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .filter-btn i {
            font-size: 0.9rem;
        }

        .filter-btn:hover {
            background: #a50000;
            transform: scale(0.98);
        }

        .dropdown-menu {
            position: absolute;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
            min-width: 160px;
            z-index: 100;
            overflow: hidden;
            border: 1px solid #eef2f8;
        }

        .dropdown-menu a {
            display: block;
            padding: 0.75rem 1rem;
            color: #c90000;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background 0.1s;
        }

        .dropdown-menu a:hover {
            background: #fff0f0;
            color: #a50000;
        }

        .paket-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-top: 1rem;
        }

        .paket-card {
            background: #ffffff;
            border: 1px solid #edf2f7;
            border-radius: 1.5rem;
            padding: 1.2rem;
            transition: all 0.2s;
        }

        .paket-card:hover {
            border-color: #dce5f0;
            box-shadow: 0 8px 18px rgba(0,0,0,0.05);
        }

        .paket-title {
            font-weight: 700;
            font-size: 1.1rem;
            color: #1e2f41;
            margin-bottom: 12px;
        }

        .paket-detail-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 16px;
            font-size: 0.9rem;
            flex-wrap: wrap;
            gap: 8px;
        }

        .paket-detail {
            color: #5e6f8d;
        }

        .paket-price {
            font-weight: 800;
            font-size: 1.2rem;
            color: #e63946;
            white-space: nowrap;
        }

        .btn-beli {
            background: #c90000;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 40px;
            color: white;
            font-weight: 600;
            font-size: 0.8rem;
            cursor: pointer;
            transition: 0.15s;
            width: 100%;
            margin-top: 10px;
            display: inline-block;
            text-align: center;
        }

        .btn-beli:hover {
            background: #a50000;
            transform: scale(0.96);
        }

        .no-data {
            text-align: center;
            padding: 3rem;
            color: #8f9bb3;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
                padding-left: 1rem;
            }
            .dashboard-inner {
                padding: 1rem;
            }
            .paket-list {
                grid-template-columns: 1fr;
            }
        }

        @media (min-width: 769px) {
            .white-dashboard {
                max-width: min(1200px, calc(100vw - 280px - 3rem));
            }
        }

        /* Notifikasi error */
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            border: 1px solid #f5c6cb;
        }
        .alert-error i {
            font-size: 1rem;
        }
    </style>
</head>
<body>
<div class="white-dashboard">
    <div class="dashboard-inner">
        <div class="phone-header">
            <div class="phone-number">
                <i class="fas fa-phone-alt"></i>
                <span>{{ $no_hp }}</span>
            </div>
            <div class="filter-group">
                <button class="filter-btn" data-filter="harga"><i class="fas fa-tag"></i> Harga</button>
                <button class="filter-btn" data-filter="kuota"><i class="fas fa-database"></i> Kuota</button>
                <button class="filter-btn" data-filter="masa"><i class="fas fa-calendar-alt"></i> Masa Berlaku</button>
            </div>
        </div>

        <!-- NOTIFIKASI ERROR -->
        @if(session('error'))
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div id="paketContainer" class="paket-list">
            @foreach($kuota as $item)
                <div class="paket-card" data-id="{{ $item->id_kuota }}">
                    <div class="paket-title">{{ $item->nama_kuota }}</div>
                    <div class="paket-detail-row">
                        <span class="paket-detail">Kuota: {{ $item->kuota }} • Masa berlaku: {{ $item->masa_berlaku }}</span>
                        <span class="paket-price">Rp{{ number_format($item->harga, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('payment.kuota', ['id_kuota' => $item->id_kuota]) }}" class="btn-beli beli-paket" data-paket="{{ $item->nama_kuota }}" data-harga="{{ $item->harga }}" data-id="{{ $item->id_kuota }}">Beli</a>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentDropdown = null;

        function closeDropdown() {
            if (currentDropdown) {
                currentDropdown.remove();
                currentDropdown = null;
            }
        }

        function resetFilter() {
            fetch('/paket_data/filter')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('paketContainer');
                    if (data.length === 0) {
                        container.innerHTML = '<div class="no-data"><i class="fas fa-box-open"></i> Tidak ada paket yang sesuai</div>';
                        return;
                    }
                    let html = '';
                    data.forEach(item => {
                        html += `
                            <div class="paket-card" data-id="${item.id_kuota}">
                                <div class="paket-title">${item.nama_kuota}</div>
                                <div class="paket-detail-row">
                                    <span class="paket-detail">Kuota: ${item.kuota} • Masa berlaku: ${item.masa_berlaku}</span>
                                    <span class="paket-price">Rp${new Intl.NumberFormat('id-ID').format(item.harga)}</span>
                                </div>
                                <button class="btn-beli beli-paket" data-paket="${item.nama_kuota}" data-harga="${item.harga}" data-id="${item.id_kuota}">Beli</button>
                            </div>
                        `;
                    });
                    container.innerHTML = html;
                    attachBeliEvent();
                })
                .catch(err => console.error(err));
        }

        function createDropdown(button, options, filterType) {
            closeDropdown();
            const rect = button.getBoundingClientRect();
            const dropdown = document.createElement('div');
            dropdown.className = 'dropdown-menu';
            dropdown.style.top = rect.bottom + window.scrollY + 4 + 'px';
            dropdown.style.left = rect.left + window.scrollX + 'px';

            const resetOption = document.createElement('a');
            resetOption.href = '#';
            resetOption.textContent = 'Reset';
            resetOption.style.fontWeight = 'bold';
            resetOption.style.borderBottom = '1px solid #eef2f8';
            resetOption.addEventListener('click', (e) => {
                e.preventDefault();
                resetFilter();
                closeDropdown();
            });
            dropdown.appendChild(resetOption);

            options.forEach(opt => {
                const a = document.createElement('a');
                a.href = '#';
                a.textContent = opt.label;
                a.addEventListener('click', (e) => {
                    e.preventDefault();
                    applyFilter(filterType, opt.value);
                    closeDropdown();
                });
                dropdown.appendChild(a);
            });
            document.body.appendChild(dropdown);
            currentDropdown = dropdown;
        }

        function applyFilter(type, value) {
            let params = {};
            if (type === 'harga') params.harga = value;
            if (type === 'kuota') params.kuota = value;
            if (type === 'masa') params.masa_berlaku = value;

            fetch('/paket_data/filter?' + new URLSearchParams(params))
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('paketContainer');
                    if (data.length === 0) {
                        container.innerHTML = '<div class="no-data"><i class="fas fa-box-open"></i> Tidak ada paket yang sesuai</div>';
                        return;
                    }
                    let html = '';
                    data.forEach(item => {
                        html += `
                            <div class="paket-card" data-id="${item.id_kuota}">
                                <div class="paket-title">${item.nama_kuota}</div>
                                <div class="paket-detail-row">
                                    <span class="paket-detail">Kuota: ${item.kuota} • Masa berlaku: ${item.masa_berlaku}</span>
                                    <span class="paket-price">Rp${new Intl.NumberFormat('id-ID').format(item.harga)}</span>
                                </div>
                                <button class="btn-beli beli-paket" data-paket="${item.nama_kuota}" data-harga="${item.harga}" data-id="${item.id_kuota}">Beli</button>
                            </div>
                        `;
                    });
                    container.innerHTML = html;
                    attachBeliEvent();
                })
                .catch(err => console.error(err));
        }

        function attachBeliEvent() {
            document.querySelectorAll('.beli-paket').forEach(btn => {
                btn.removeEventListener('click', beliHandler);
                btn.addEventListener('click', beliHandler);
            });
        }

        function beliHandler(e) {
            e.stopPropagation();
            const paket = this.getAttribute('data-paket');
            const harga = this.getAttribute('data-harga');
        }

        function showToast(msg, type) {
            const toast = document.createElement('div');
            toast.style.position = 'fixed';
            toast.style.bottom = '24px';
            toast.style.left = '50%';
            toast.style.transform = 'translateX(-50%)';
            toast.style.backgroundColor = type === 'success' ? '#0f2c29' : '#1e2a36';
            toast.style.color = 'white';
            toast.style.padding = '12px 20px';
            toast.style.borderRadius = '60px';
            toast.style.fontSize = '0.85rem';
            toast.style.zIndex = '9999';
            toast.style.boxShadow = '0 12px 22px rgba(0,0,0,0.2)';
            toast.innerHTML = `<i class="fas fa-check-circle" style="margin-right: 8px;"></i> ${msg}`;
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 2400);
        }

        const filterButtons = document.querySelectorAll('.filter-btn');
        filterButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const filter = btn.getAttribute('data-filter');
                let options = [];
                if (filter === 'harga') {
                    options = [
                        { label: '< Rp15.000', value: '<15000' },
                        { label: '< Rp25.000', value: '<25000' },
                        { label: 'Rp25.000 - Rp50.000', value: '25000-50000' },
                        { label: 'Rp50.000 - Rp100.000', value: '50000-100000' }
                    ];
                } else if (filter === 'kuota') {
                    options = [
                        { label: '0 - 5 GB', value: '0-5' },
                        { label: '6 - 10 GB', value: '6-10' },
                        { label: '11 - 15 GB', value: '11-15' },
                        { label: '16 - 20 GB', value: '16-20' }
                    ];
                } else if (filter === 'masa') {
                    options = [
                        { label: '< 5 hari', value: '5' },
                        { label: '< 8 hari', value: '8' },
                        { label: '< 15 hari', value: '15' },
                        { label: '< 30 hari', value: '30' }
                    ];
                }
                createDropdown(btn, options, filter);
            });
        });

        document.addEventListener('click', function(e) {
            if (currentDropdown && !currentDropdown.contains(e.target) && !e.target.classList.contains('filter-btn')) {
                closeDropdown();
            }
        });

        attachBeliEvent();
    });
</script>
</body>
</html>
@include('footer')
