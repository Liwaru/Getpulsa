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

        /* MAIN WHITE CARD (TABLE / CONTAINER) */
        .white-dashboard {
            max-width: 480px;
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

        /* inner content padding (white table area) */
        .dashboard-inner {
            padding: 1.5rem 1.25rem 2rem 1.25rem;
        }

        /* ========== status bar (9:41) ========== */
        .status-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
            font-weight: 500;
            color: #1c1e24;
            letter-spacing: 0.2px;
        }
        .time {
            font-weight: 600;
            background: #f5f7fb;
            padding: 0.2rem 0.7rem;
            border-radius: 30px;
            font-size: 0.8rem;
        }
        .battery-icons i {
            margin-left: 4px;
            color: #3a3f4b;
            font-size: 0.75rem;
        }

        /* profile: DB Dave + Platinum poin */
        .profile-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .avatar {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, #1e2a3e, #0f1722);
            border-radius: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.5rem;
            box-shadow: 0 6px 12px -6px rgba(0,0,0,0.1);
        }
        .user-text h2 {
            font-size: 1.35rem;
            font-weight: 700;
            color: #0a0c12;
            letter-spacing: -0.3px;
        }
        .badge-platinum {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f2efe7;
            padding: 0.25rem 0.75rem;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: 600;
            color: #b47c2e;
            margin-top: 4px;
        }
        .badge-platinum i {
            font-size: 0.7rem;
            color: #e5a443;
        }
        .points-value {
            font-weight: 700;
            color: #a1621a;
        }

        /* PraBayar section */
        .prabayar-card {
            background: #f8fafd;
            border-radius: 1.25rem;
            padding: 0.85rem 1rem;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #eef2f8;
        }
        .prabayar-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .prabayar-left i {
            font-size: 1.25rem;
            color: #2c7da0;
            background: white;
            padding: 6px;
            border-radius: 40px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        }
        .prabayar-number {
            font-weight: 600;
            color: #1f2a3e;
            letter-spacing: -0.2px;
        }
        .prabayar-label {
            font-size: 0.7rem;
            color: #5e6f8d;
            font-weight: 500;
        }
        .copy-icon {
            color: #7d8fab;
            cursor: pointer;
            transition: 0.2s;
            padding: 5px;
        }
        .copy-icon:hover {
            color: #1e4663;
        }

        /* stats row: pulsa + kuota */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.2rem;
        }
        .stat-block {
            background: #ffffff;
            border-radius: 1.25rem;
            padding: 0.85rem 0.9rem;
            border: 1px solid #eef2f8;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
            transition: all 0.2s;
        }
        .stat-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            font-weight: 600;
            color: #6c7a91;
            letter-spacing: 0.3px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .stat-amount {
            font-size: 1.65rem;
            font-weight: 800;
            color: #121826;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }
        .stat-sub {
            font-size: 0.7rem;
            color: #2c7a4d;
            font-weight: 500;
        }

        /* tambah layanan button */
        .add-service-btn {
            background: #f0f4fa;
            border-radius: 60px;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            width: 100%;
            font-weight: 600;
            color: #1f4973;
            font-size: 0.9rem;
        }
        .add-service-btn i {
            font-size: 1rem;
            background: white;
            border-radius: 30px;
            padding: 5px 8px;
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
            margin: 1.5rem 0 0.9rem 0;
        }
        .for-you-heading h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0e141b;
            letter-spacing: -0.3px;
        }
        .for-you-heading span {
            font-size: 0.7rem;
            color: #3c6e9f;
            font-weight: 500;
        }

        /* offer cards (white table rows / cards) */
        .offers-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .offer-card {
            background: #ffffff;
            border-radius: 1.5rem;
            border: 1px solid #edf2f7;
            padding: 1rem;
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
            gap: 10px;
            margin-bottom: 8px;
        }
        .offer-header i {
            font-size: 1.2rem;
            background: #f0f3f9;
            padding: 6px;
            border-radius: 40px;
            color: #2266a8;
        }
        .offer-header h4 {
            font-weight: 700;
            font-size: 1rem;
            color: #1e2f41;
        }
        .offer-desc {
            font-size: 0.85rem;
            font-weight: 500;
            color: #2c3e4e;
            margin: 6px 0 4px 0;
        }
        .offer-meta {
            font-size: 0.7rem;
            color: #e67e22;
            background: #fff3e9;
            display: inline-block;
            padding: 2px 10px;
            border-radius: 20px;
            margin: 6px 0;
            font-weight: 500;
        }
        .price-row {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-top: 10px;
            flex-wrap: wrap;
            gap: 8px;
        }
        .price {
            font-weight: 800;
            font-size: 1.3rem;
            color: #0b2a3e;
        }
        .price-striked {
            font-size: 0.8rem;
            color: #8f9bb3;
            text-decoration: line-through;
            margin-left: 6px;
            font-weight: 400;
        }
        .btn-beli {
            background: #10161f;
            border: none;
            padding: 0.5rem 1.1rem;
            border-radius: 40px;
            color: white;
            font-weight: 600;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: 0.15s linear;
            font-family: inherit;
        }
        .btn-beli i {
            font-size: 0.7rem;
        }
        .btn-beli:hover {
            background: #2c3e4f;
            transform: scale(0.96);
        }
        .warning-text {
            font-size: 0.7rem;
            color: #c2410c;
            font-weight: 500;
            background: #fff0e6;
            padding: 4px 10px;
            border-radius: 40px;
            display: inline-block;
        }
        hr {
            margin: 8px 0;
            border: 0;
            height: 1px;
            background: #eef2f8;
        }
        .section-divider {
            margin-top: 0.75rem;
        }
        .small-note {
            font-size: 0.65rem;
            color: #8d9bb0;
            margin-top: 1rem;
            text-align: center;
        }
        button {
            background: none;
            border: none;
        }
    </style>
</head>
<body>
<div class="white-dashboard">
    <div class="dashboard-inner">
        <div class="profile-row">
            <div class="user-info">
                <div class="avatar">{{ strtoupper(substr(session('name'), 0, 1)) }}</div>
                <div class="user-text">
                    <h2>{{ session('name') }}</h2>
                </div>
            </div>
            <i class="fas fa-chevron-right" style="color:#9aaec7; font-size: 0.9rem;"></i>
        </div>

        <!-- PraBayar 0812 2933 XXXX -->
        <div class="prabayar-card">
            <div class="prabayar-left">
                <i class="fas fa-credit-card"></i>
                <div>
                    <div class="prabayar-label">PraBayar</div>
                    <div class="prabayar-number">0812 2933 XXXX</div>
                </div>
            </div>
            <div class="copy-icon" id="copyPhoneBtn" title="salin nomor">
                <i class="far fa-copy"></i>
            </div>
        </div>

        <!-- Sisa Pulsa & Sisa Kuota (statistic white blocks) -->
        <div class="stats-grid">
            <div class="stat-block">
                <div class="stat-label"><i class="fas fa-credit-card"></i> Sisa Pulsa</div>
                <div class="stat-amount">Rp120.000<span style="font-size:1rem;">+</span></div>
                <div class="stat-sub">masa aktif panjang</div>
            </div>
            <div class="stat-block">
                <div class="stat-label"><i class="fas fa-database"></i> Sisa Kuota</div>
                <div class="stat-amount">8.0 <span style="font-size:1rem;">GB</span></div>
                <div class="stat-sub">tersisa hingga 25 Apr</div>
            </div>
        </div>

        <!-- Tombol Tambah Layanan + -->
        <button class="add-service-btn" id="tambahLayananBtn">
            <span><i class="fas fa-plus-circle"></i> Tambah Layanan +</span>
            <i class="fas fa-arrow-right"></i>
        </button>

        <!-- ========== FOR YOU SECTION 1 (Beli Lagi + Promo) ========== -->
        <div class="for-you-heading">
            <h3>For You</h3>
            <span>Rekomendasi <i class="fas fa-chevron-right"></i></span>
        </div>
        <div class="offers-list">
            <!-- Card 1 : Beli Lagi - Internet Sakti 5GB -->
            <div class="offer-card" data-offer="internet-sakti">
                <div class="offer-header">
                    <i class="fas fa-shopping-bag"></i>
                    <h4>Beli Lagi</h4>
                </div>
                <div class="offer-desc">Internet Sakti 5 GB • 14 Hari</div>
                <div class="warning-text"><i class="fas fa-exclamation-triangle"></i> Kuota kamu sudah habis</div>
                <div class="price-row">
                    <div class="price">Rp23.150</div>
                    <button class="btn-beli beli-action" data-paket="Internet Sakti 5GB - Rp23.150">
                        <i class="fas fa-bolt"></i> Beli
                    </button>
                </div>
            </div>

            <!-- Card 2 : Promo - Combo Sakti 30GB -->
            <div class="offer-card" data-offer="combo-sakti">
                <div class="offer-header">
                    <i class="fas fa-tag"></i>
                    <h4>Promo</h4>
                </div>
                <div class="offer-desc">Combo Sakti 30 GB • 30 Hari</div>
                <div class="offer-meta"><i class="fas fa-gem"></i> Lebih hemat untuk kamu</div>
                <div class="price-row">
                    <div>
                        <span class="price">Rp92.000</span>
                        <span class="price-striked">Rp100.000</span>
                    </div>
                    <button class="btn-beli beli-action" data-paket="Combo Sakti 30GB - Rp92.000 (hemat Rp8.000)">
                        <i class="fas fa-bolt"></i> Beli
                    </button>
                </div>
            </div>
        </div>

        <!-- ========== FOR YOU SECTION 2 (Beli Lagi - PraBayar 0812) ========== -->
        <div class="for-you-heading" style="margin-top: 1.8rem;">
            <h3>For You</h3>
            <span>Personal</span>
        </div>
        <div class="offers-list">
            <!-- Card 3 : Beli Lagi - PraBayar 0812 2933 XXXX + paket akan berakhir -->
            <div class="offer-card" data-offer="prabayar-renew">
                <div class="offer-header">
                    <i class="fas fa-sync-alt"></i>
                    <h4>Beli Lagi</h4>
                </div>
                <div class="offer-desc">PraBayar 0812 2933 XXXX</div>
                <div class="warning-text"><i class="fas fa-hourglass-half"></i> Paket akan berakhir 3 hari lagi</div>
                <div class="price-row">
                    <div class="price">Rp23.150</div>
                    <button class="btn-beli beli-action" data-paket="Perpanjangan PraBayar - Rp23.150">
                        <i class="fas fa-bolt"></i> Beli
                    </button>
                </div>
            </div>
        </div>

        <!-- subtle footer: informasi layanan -->
        <div class="small-note">
            <i class="fas fa-shield-alt"></i> Transaksi aman • Powered by Dashboard
        </div>
    </div>
</div>

<!-- JavaScript interaktif (simulasi & notifikasi) -->
<script>
    (function() {
        // Fungsi notifikasi sederhana (toast style)
        function showToast(message, type = 'info') {
            // membuat elemen toast dinamis (modern)
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

        // --- Salin nomor PraBayar ---
        const copyBtn = document.getElementById('copyPhoneBtn');
        if (copyBtn) {
            copyBtn.addEventListener('click', (e) => {
                e.preventDefault();
                const phoneNumber = '0812 2933 XXXX';
                navigator.clipboard.writeText(phoneNumber).then(() => {
                    showToast(`Nomor ${phoneNumber} disalin ke clipboard`, 'success');
                }).catch(() => {
                    showToast('Gagal menyalin, coba manual', 'info');
                });
            });
        }

        // --- Tombol Tambah Layanan ---
        const tambahBtn = document.getElementById('tambahLayananBtn');
        if (tambahBtn) {
            tambahBtn.addEventListener('click', () => {
                showToast('✨ Fitur tambahan layanan: Internet, Pulsa, Game Voucher (demo)', 'info');
            });
        }

        // --- Semua tombol "Beli" pada paket (Beli Lagi & Promo) ---
        const beliButtons = document.querySelectorAll('.beli-action');
        beliButtons.forEach(btn => {
            btn.addEventListener('click', (event) => {
                event.stopPropagation();  // mencegah event bubbling ke card
                const packageName = btn.getAttribute('data-paket') || 'Paket pilihan';
                // simulasi proses pembelian dalam environment tes authorized
                showToast(`✅ [TEST MODE] Pembelian ${packageName} berhasil diproses (simulasi authorized)`, 'success');
                // efek tambahan: console log untuk audit
                console.log(`[DarkForge-X | Audit] Purchase initiated: ${packageName} at ${new Date().toISOString()}`);
            });
        });

        // Tambahan interaksi untuk card (opsional: menunjukkan detail)
        const allOffers = document.querySelectorAll('.offer-card');
        allOffers.forEach(card => {
            card.addEventListener('click', (e) => {
                // jika klik bukan pada tombol beli, kita hanya memberi efek ringan untuk user experience
                if (e.target.classList && !e.target.classList.contains('beli-action') && !e.target.closest('.beli-action')) {
                    const titleCard = card.querySelector('h4')?.innerText || 'Paket';
                    showToast(`Detail: ${titleCard} — silakan tekan tombol Beli untuk pembelian resmi`, 'info');
                }
            });
        });

        // efek visual untuk stats block agar lebih hidup (optional)
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
        
        // Simulasi bonus: tampilkan pesan selamat datang di console (authorized test environment)
        console.log('DarkForge-X | White Table Component Loaded — fully authorized simulation dashboard');
    })();
</script>
</body>
</html>
@include ('footer')