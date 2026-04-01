@include ('header')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <title>PraBayar Dashboard — White Card Interface</title>
    <!-- Font Awesome 6 (free icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts: Inter + fallback -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(145deg, #e9eef3 0%, #dce2ea 100%);
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, Helvetica, sans-serif;
            padding: 1.5rem;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* MAIN WHITE CARD (TABLE / CONTAINER) - DIPERBESAR */
        .white-dashboard {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 2rem;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.02);
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .white-dashboard:hover {
            transform: translateY(-2px);
            box-shadow: 0 28px 40px -16px rgba(0, 0, 0, 0.18);
        }

        .dashboard-inner {
            padding: 2rem 2rem 2.5rem 2rem;
        }

        /* ===== GABUNGAN profile, prabayar, stats ===== */
        .user-overview {
            background: #f8fafd;
            border-radius: 1.5rem;
            margin-bottom: 1.8rem;
            padding: 1.2rem 1.5rem;
            border: 1px solid #eef2f8;
        }

        /* profile row dalam gabungan */
        .profile-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #eb0000, #a50000);
            border-radius: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.8rem;
            box-shadow: 0 6px 12px -6px rgba(0,0,0,0.1);
        }
        .user-text h2 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #da0000;
            letter-spacing: -0.3px;
        }

        /* welcome message di sebelah kanan */
        .welcome-message {
            font-size: 1rem;
            font-weight: 500;
            background: #eef2f8;
            padding: 0.4rem 1rem;
            border-radius: 30px;
            color: #d80000;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }
        .welcome-message i {
            font-size: 0.9rem;
        }

        /* PraBayar section dalam gabungan (tanpa background terpisah) */
        .prabayar-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .prabayar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .prabayar-left i {
            font-size: 1.3rem;
            color: #d80000;
            background: white;
            padding: 8px;
            border-radius: 40px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        }
        .prabayar-number {
            font-weight: 600;
            font-size: 1rem;
            color: #000000;
        }
        .prabayar-label {
            font-size: 0.75rem;
            color: #5e6f8d;
            font-weight: 500;
        }
        .copy-icon {
            color: #c90000;
            cursor: pointer;
            transition: 0.2s;
            padding: 5px;
            font-size: 1.1rem;
        }
        .copy-icon:hover {
            color: #1e4663;
        }

        /* stats grid dalam gabungan */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 0.8rem;
        }
        .stat-block {
            background: #ffffff;
            border-radius: 1.25rem;
            padding: 0.8rem 1rem;
            border: 1px solid #eef2f8;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
            transition: all 0.2s;
        }
        .stat-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 600;
            color: #d80000;
            letter-spacing: 0.3px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .stat-amount {
            font-size: 1.8rem;
            font-weight: 800;
            color: #121826;
            letter-spacing: -0.5px;
            line-height: 1.2;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .stat-sub {
            font-size: 0.75rem;
            color: #2c7a4d;
            font-weight: 500;
        }

        /* Lingkaran dengan tanda + */
        .plus-circle {
            width: 20px;
            height: 20px;
            background: #ff4d4d;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.2s;
            border: none;
            color: white;
            font-size: 1rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .plus-circle:hover {
            background: #e60000;
            transform: scale(1.05);
        }
        .plus-circle i {
            font-size: 0.7rem;
        }

        /* tombol tambah layanan tetap sendiri */
        .add-service-btn {
            background: #f0f4fa;
            border-radius: 60px;
            padding: 0.9rem 1.2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            width: 100%;
            font-weight: 600;
            color: #d80000;
            font-size: 1rem;
        }
        .add-service-btn i {
            font-size: 1.1rem;
            background: white;
            border-radius: 30px;
            padding: 6px 10px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .add-service-btn:hover {
            background: #e6edf6;
            transform: scale(0.99);
        }

        /* For You section heading */
        .for-you-heading {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin: 1.8rem 0 1rem 0;
        }
        .for-you-heading h3 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #c90000;
            letter-spacing: -0.3px;
        }
        .for-you-heading span {
            font-size: 0.8rem;
            color: #c90000;
            font-weight: 500;
        }

        /* offer cards (white table rows / cards) */
        .offers-list {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }
        .offer-card {
            background: #ffffff;
            border-radius: 1.5rem;
            border: 1px solid #edf2f7;
            padding: 1.2rem;
            transition: all 0.2s;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.02);
        }
        .offer-card:hover {
            border-color: #dce5f0;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.05);
        }
        .offer-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }
        .offer-header i {
            font-size: 1.3rem;
            background: #f0f3f9;
            padding: 8px;
            border-radius: 40px;
            color: #c90000;
        }
        .offer-header h4 {
            font-weight: 700;
            font-size: 1.1rem;
            color: #1e2f41;
        }
        .offer-desc {
            font-size: 0.95rem;
            font-weight: 500;
            color: #2c3e4e;
            margin: 8px 0 6px 0;
        }
        .offer-meta {
            font-size: 0.75rem;
            color: #e67e22;
            background: #fff3e9;
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            margin: 8px 0;
            font-weight: 500;
        }
        .price-row {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-top: 12px;
            flex-wrap: wrap;
            gap: 8px;
        }
        .price {
            font-weight: 800;
            font-size: 1.5rem;
            color: #0b2a3e;
        }
        .price-striked {
            font-size: 0.9rem;
            color: #8f9bb3;
            text-decoration: line-through;
            margin-left: 8px;
            font-weight: 400;
        }
/* Tombol Beli */
.btn-beli {
    background: #c90000;  /* merah brand */
    border: none;
    padding: 0.6rem 1.3rem;
    border-radius: 40px;
    color: white;
    font-weight: 600;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: 0.15s linear;
    font-family: inherit;
    text-decoration: none;
}
.btn-beli:hover {
    background: #a50000;
    transform: scale(0.96);
}

/* Harga */
.price {
    font-weight: 800;
    font-size: 1.5rem;
    color: #e63946;  /* merah terang */
    /* atau tetap hitam jika ingin netral: #0b2a3e */
}

.offer-desc {
    color: #2c3e4e;  /* netral */
}

/* Teks rekomendasi positif (ganti dari warning-text ke kelas baru) */
.recommend-text {
    font-size: 0.75rem;
    color: #2e7d32;
    font-weight: 500;
    background: #e8f5e9;
    padding: 4px 12px;
    border-radius: 40px;
    display: inline-block;
}        .warning-text {
            font-size: 0.75rem;
            color: #c2410c;
            font-weight: 500;
            background: #fff0e6;
            padding: 4px 12px;
            border-radius: 40px;
            display: inline-block;
        }
        .small-note {
            font-size: 0.7rem;
            color: #b90000;
            margin-top: 1.5rem;
            text-align: center;
        }

        /* NOTIFIKASI TOP CENTER */
        .top-notification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #2e7d32;
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(8px);
            background: rgba(46, 125, 50, 0.95);
            border: 1px solid rgba(255,255,255,0.2);
            transition: opacity 0.3s ease;
        }
        .top-notification.hide {
            opacity: 0;
            visibility: hidden;
        }

        /* Notifikasi tengah (center) dengan efek klik hapus */
        /* Base untuk notifikasi (digunakan untuk sukses dan error) */
        .center-notification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            z-index: 9999;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            backdrop-filter: blur(6px);
        }
        .center-notification i:first-child {
            font-size: 1rem;
        }
        .center-notification:hover {
            transform: translateX(-50%) scale(1.02);
        }
        .center-notification .close-icon {
            margin-left: 8px;
            font-size: 0.8rem;
            opacity: 0.8;
        }
        /* Warna untuk sukses */
        .center-notification.success {
            background: rgba(46, 125, 50, 0.96);
        }
        /* Warna untuk error */
        .center-notification.error {
            background: rgba(220, 53, 69, 0.96);
        }
        .center-notification.error:hover {
            background: rgba(200, 40, 55, 0.96);
        }

        /* Responsif */
        @media (max-width: 768px) {
            .white-dashboard {
                max-width: 95%;
            }
            .dashboard-inner {
                padding: 1.2rem;
            }
            .stat-amount {
                font-size: 1.4rem;
            }
            .price {
                font-size: 1.2rem;
            }
            .user-text h2 {
                font-size: 1.3rem;
            }
            .user-overview {
                padding: 1rem;
            }
            .plus-circle {
                width: 28px;
                height: 28px;
                font-size: 0.9rem;
            }
            .welcome-message {
                font-size: 0.8rem;
                padding: 0.3rem 0.8rem;
                white-space: normal;
            }
            .top-notification {
                padding: 8px 16px;
                font-size: 0.8rem;
                top: 10px;
            }
        }
    </style>
</head>
<body>

<!-- NOTIFIKASI TOP CENTER (untuk sukses update profil dll) -->
<!-- @if(session('success'))
<div id="topNotif" class="top-notification">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif -->

<!-- TIDAK ADA LAGI DIV ALERT-ERROR, DIGANTI DENGAN NOTIFIKASI JAVASCRIPT -->

<div class="white-dashboard">
    <div class="dashboard-inner">
        <!-- GABUNGAN profile, prabayar, stats grid -->
        <div class="user-overview">
            <!-- Profile -->
            <div class="profile-row">
                <div class="user-info">
                    <div class="avatar">{{ strtoupper(substr(session('name'), 0, 1)) }}</div>
                    <div class="user-text">
                        <h2>{{ session('name') }}</h2>
                    </div>
                </div>
                <!-- Welcome message di sebelah kanan -->
                <div class="welcome-message">
                     Selamat datang, {{ session('name') }}
                </div>
            </div>

            <!-- PraBayar dengan ikon telepon dan nomor dari session -->
            <div class="prabayar-card">
                <div class="prabayar-left">
                    <i class="fas fa-phone-alt"></i>
                    <div>
                        <div class="prabayar-number" id="phoneNumberDisplay">{{ session('phone') ?? session('no_hp_user') ?? 'Nomor tidak tersedia' }}</div>
                    </div>
                </div>
                <div class="copy-icon" id="copyPhoneBtn" title="salin nomor">
                    <i class="far fa-copy"></i>
                </div>
            </div>

            <!-- Stats grid (pulsa & kuota) -->
            <div class="stats-grid">
                <div class="stat-block">
                    <div class="stat-label"><i class="fas fa-credit-card"></i> Sisa Pulsa</div>
                    <div class="stat-amount">
                        Rp{{ session('total_pulsa') ?? '0' }}
                        <!-- Lingkaran dengan tanda + disamping angka 0 -->
                        <button class="plus-circle" id="plusPulsaBtn" title="Tambah pulsa">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="stat-block">
                    <div class="stat-label"><i class="fas fa-database"></i> Sisa Kuota</div>
                    <div class="stat-amount">{{ number_format(session('total_kuota') ?? 0, 1) }} <span style="font-size:1rem;">GB</span>
                        <button class="plus-circle" id="plusKuotaBtn" title="Tambah kuota">
                            <i class="fas fa-plus"></i>
                        </button>
</div>
                </div>
            </div>
        </div>

        <!-- Tombol Tambah Layanan + -->
        <button class="add-service-btn" id="tambahLayananBtn">
            <span><i class="fas fa-plus-circle"></i> Tambah Layanan +</span>
            <i class="fas fa-arrow-right"></i>
        </button>

        <!-- ========== FOR YOU SECTION 1 ========== -->
        <div class="for-you-heading">
            <h3>Untuk Kamu</h3>
        </div>
<div class="offers-list">
    @foreach($kuota as $item)
        <div class="offer-card" data-offer="{{ $item->id_kuota }}">
            <div class="offer-header">
                <!-- Sesuaikan ikon berdasarkan id_kuota (opsional) -->
                @if($item->id_kuota == 5)
                    <i class="fas fa-lightbulb"></i>
                    <h4>Saran</h4>
                @elseif($item->id_kuota == 6)
                    <i class="fas fa-tag"></i>
                    <h4>Promo</h4>
                @else
                    <i class="fas fa-tag"></i>
                    <h4>Paket Data</h4>
                @endif
            </div>
            <div class="offer-desc">
                {{ $item->kuota }} • {{ $item->masa_berlaku }}
            </div>
            <!-- Tambahkan elemen meta/warning jika diperlukan, misal untuk id 5 -->
            @if($item->id_kuota == 5)
<div class="recommend-text">
    <i class="fas fa-thumbs-up"></i> lebih cocok untuk kamu
</div>            @endif
            @if($item->id_kuota == 6)
                <div class="offer-meta"><i class="fas fa-gem"></i> Lebih hemat untuk kamu</div>
            @endif
            <div class="price-row">
                <div>
                    <span class="price">Rp{{ number_format($item->harga, 0, ',', '.') }}</span>
                    @if($item->id_kuota == 6)
                        <span class="price-striked">Rp100.000</span> <!-- harga coret contoh -->
                    @endif
                </div>
                <a href="{{ route('payment.kuota', ['id_kuota' => $item->id_kuota]) }}" class="btn-beli">Beli</a>
            </div>
        </div>
    @endforeach
</div>
        <div class="small-note">
            <i class="fas fa-shield-alt"></i> Transaksi aman • Powered by Getpulsa
        </div>
    </div>
</div>

<script>
    (function() {
        function showToast(message, type = 'info') {
            const toastContainer = document.createElement('div');
            toastContainer.style.position = 'fixed';
            toastContainer.style.bottom = '24px';
            toastContainer.style.left = '50%';
            toastContainer.style.transform = 'translateX(-50%)';
            toastContainer.style.backgroundColor = type === 'success' ? '#1f3b4c' : '#2c2e3a';
            toastContainer.style.color = 'white';
            toastContainer.style.padding = '12px 20px';
            toastContainer.style.borderRadius = '60px';
            toastContainer.style.fontSize = '0.85rem';
            toastContainer.style.fontWeight = '500';
            toastContainer.style.zIndex = '9999';
            toastContainer.style.backdropFilter = 'blur(8px)';
            toastContainer.style.background = type === 'success' ? '#0f2c29' : '#1e2a36';
            toastContainer.style.boxShadow = '0 12px 22px rgba(0,0,0,0.2)';
            toastContainer.style.border = '1px solid rgba(255,255,255,0.15)';
            toastContainer.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-info-circle'}" style="margin-right: 8px;"></i> ${message}`;
            document.body.appendChild(toastContainer);
            setTimeout(() => {
                toastContainer.style.opacity = '0';
                toastContainer.style.transition = 'opacity 0.25s';
                setTimeout(() => {
                    if (toastContainer.parentNode) toastContainer.parentNode.removeChild(toastContainer);
                }, 300);
            }, 2400);
        }

        const copyBtn = document.getElementById('copyPhoneBtn');
        if (copyBtn) {
            copyBtn.addEventListener('click', (e) => {
                e.preventDefault();
                const phoneElement = document.getElementById('phoneNumberDisplay');
                const phoneNumber = phoneElement ? phoneElement.innerText : 'Nomor tidak ditemukan';
                navigator.clipboard.writeText(phoneNumber).then(() => {
                    showToast(`Nomor ${phoneNumber} disalin ke clipboard`, 'success');
                }).catch(() => {
                    showToast('Gagal menyalin, coba manual', 'info');
                });
            });
        }

        const tambahBtn = document.getElementById('tambahLayananBtn');
        if (tambahBtn) {
            tambahBtn.addEventListener('click', () => {
                window.location.href = '/paket_data';
            });
        }

        const plusPulsaBtn = document.getElementById('plusPulsaBtn');
        if (plusPulsaBtn) {
            plusPulsaBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                window.location.href = '/tambah_pulsa';
            });
        }

        // ========== TAMBAHKAN UNTUK TOMBOL + KUOTA ==========
        const plusKuotaBtn = document.getElementById('plusKuotaBtn');
        if (plusKuotaBtn) {
            plusKuotaBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                window.location.href = '/paket_data';
            });
        }

        // ========== TOMBOL BELI SUDAH DIGANTI DENGAN LINK, JADI HAPUS EVENT LISTENER ==========
        // (tidak ada lagi listener untuk .beli-action)

        const allOffers = document.querySelectorAll('.offer-card');
        allOffers.forEach(card => {
            card.addEventListener('click', (e) => {
                // Jangan ganggu jika yang diklik adalah tombol beli (link)
                if (e.target.classList && (e.target.classList.contains('btn-beli') || e.target.closest('.btn-beli'))) {
                    return;
                }
                const titleCard = card.querySelector('h4')?.innerText || 'Paket';
                showToast(`Detail: ${titleCard} — silakan tekan tombol Beli untuk pembelian resmi`, 'info');
            });
        });

        const statBlocks = document.querySelectorAll('.stat-block');
        statBlocks.forEach(block => {
            block.addEventListener('mouseenter', () => {
                block.style.backgroundColor = '#fefefe';
                block.style.borderColor = '#cddfed';
            });
            block.addEventListener('mouseleave', () => {
                block.style.backgroundColor = '#ffffff';
                block.style.borderColor = '#eef2f8';
            });
        });

        // ========== NOTIFIKASI SELAMAT DATANG (TOAST BAWAH) ==========
        const welcomeMsg = '{{ session("welcome") }}';
        const hasTopNotif = document.getElementById('topNotif') !== null;
        if (welcomeMsg && welcomeMsg.trim() !== '' && !hasTopNotif) {
            showToast(welcomeMsg, 'success');
        }

        // ========== AUTO HIDE TOP NOTIFICATION ==========
        const topNotif = document.getElementById('topNotif');
        if (topNotif) {
            setTimeout(() => {
                topNotif.classList.add('hide');
                setTimeout(() => {
                    if (topNotif.parentNode) topNotif.parentNode.removeChild(topNotif);
                }, 300);
            }, 3000);
        }

        console.log('DarkForge-X | White Table Component Loaded — fully authorized simulation dashboard');
    })();

    // Fungsi menampilkan notifikasi sukses di tengah atas (dapat diklik)
    function showCenterNotification(message, type = 'success') {
        const notif = document.createElement('div');
        // Tentukan kelas berdasarkan tipe
        notif.className = 'center-notification ' + type;
        
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        notif.innerHTML = `
            <i class="fas ${icon}"></i>
            <span>${message}</span>
            <i class="fas fa-times close-icon"></i>
        `;
        
        document.body.appendChild(notif);
        
        // Klik pada notifikasi (atau tombol close) akan menghapusnya
        notif.addEventListener('click', (e) => {
            notif.remove();
        });
        
        // Otomatis hilang setelah 5 detik
        setTimeout(() => {
            if (notif.parentNode) notif.remove();
        }, 5000);
    }

    // Jika ada session success, tampilkan notifikasi sukses
    @if(session('success'))
        showCenterNotification('{{ session('success') }}', 'success');
    @endif

    // Jika ada session error, tampilkan notifikasi error
    @if(session('error'))
        showCenterNotification('{{ session('error') }}', 'error');
    @endif
</script>
</body>
</html>
@include ('footer')