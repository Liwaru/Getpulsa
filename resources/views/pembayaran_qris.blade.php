@include('header')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Pembayaran QRIS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: #efefef !important;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            color: #1f2937;
        }

        .content-area {
            display: none !important;
            min-height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .qris-layout {
            margin-left: 280px;
            width: calc(100vw - 280px);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            padding: 0 1.5rem;
        }

        .qris-shell {
            max-width: 640px;
            width: 100%;
            margin: 0;
            min-height: 100vh;
            background: #f4f4f4;
        }

        @media (max-width: 768px) {
            .qris-layout {
                margin-left: 0;
                padding: 0;
            }

            .qris-shell {
                max-width: 460px;
            }
        }

        .qris-header {
            background: #ffffff;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            position: sticky;
            top: 0;
            z-index: 10;
            border-bottom: 1px solid #ececec;
        }

        .back-link {
            position: absolute;
            left: 1rem;
            color: #374151;
            text-decoration: none;
            font-size: 1.2rem;
        }

        .qris-header h1 {
            font-size: 1.1rem;
            font-weight: 700;
        }

        .qris-body {
            padding: 1rem;
        }

        .section-title {
            text-align: center;
            font-size: 1.45rem;
            font-weight: 700;
            margin: 0.75rem 0 1.25rem;
            letter-spacing: 0.03em;
        }

        .qr-card,
        .timer-card,
        .status-card {
            background: #ffffff;
            border-radius: 1.25rem;
            padding: 1.75rem 2rem;
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.08);
            margin-bottom: 1rem;
        }

        .qr-instruction {
            text-align: center;
            color: #4b5563;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .qris-logo {
            display: block;
            width: 78px;
            margin: 0 auto 1rem;
        }

        .qr-image-wrap {
            display: flex;
            justify-content: center;
        }

        .qr-image {
            width: min(100%, 360px);
            aspect-ratio: 1 / 1;
            border-radius: 0.75rem;
            border: 1px solid #ececec;
            background: #fff;
            padding: 0.75rem;
        }

        .timer-card {
            background: #fff6ea;
            text-align: center;
        }

        .timer-label {
            font-size: 0.95rem;
            color: #4b5563;
            margin-bottom: 0.75rem;
        }

        .timer-value {
            font-size: 2rem;
            font-weight: 800;
            color: #111827;
            letter-spacing: 0.04em;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.4rem 0;
            font-size: 0.95rem;
        }

        .summary-row strong {
            font-size: 1.05rem;
        }

        .status-card {
            text-align: center;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 120px;
            padding: 0.55rem 1rem;
            border-radius: 999px;
            font-weight: 700;
            text-transform: capitalize;
            margin-bottom: 0.85rem;
        }

        .status-diproses {
            background: #fff4cc;
            color: #9a6700;
        }

        .status-berhasil {
            background: #dcfce7;
            color: #166534;
        }

        .status-gagal {
            background: #fee2e2;
            color: #991b1b;
        }

        .action-stack {
            display: grid;
            gap: 0.85rem;
            margin-top: 1rem;
        }

        .action-btn {
            width: 100%;
            border-radius: 999px;
            padding: 0.95rem 1rem;
            text-align: center;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .action-btn-primary {
            background: #df001f;
            color: #fff;
            border: none;
        }

        .action-btn-secondary {
            background: #fff;
            color: #df001f;
            border: 2px solid #df001f;
        }

        .small-note {
            font-size: 0.7rem;
            color: #b90000;
            margin-top: 1.5rem;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="qris-layout">
    <div class="qris-shell">
        <div class="qris-header">
            <a href="{{ url()->previous() }}" class="back-link" aria-label="Kembali">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>Metode Pembayaran</h1>
        </div>

        <div class="qris-body">
            <div class="section-title">QRIS</div>

            <div class="qr-card">
                <div class="qr-instruction">Scan atau unduh QR code</div>
                <img class="qris-logo" src="{{ asset('images/qris.jpg') }}" alt="QRIS">
                <div class="qr-image-wrap">
                    <img class="qr-image" id="qrImage" src="{{ $qr_url }}" alt="QR Code Pembayaran QRIS">
                </div>
            </div>

            <div class="timer-card">
                <div class="timer-label">Selesaikan pembayaran dalam</div>
                <div class="timer-value" id="countdown">00:00:00</div>
            </div>

            <div class="status-card">
                <div class="status-pill status-{{ $transaction->status }}" id="statusBadge">{{ ucfirst($transaction->status) }}</div>
                <div id="statusMessage">Midtrans akan memperbarui status pembayaran secara otomatis setelah QRIS dibayar.</div>
            </div>

            <div class="qr-card">
                <div class="summary-row">
                    <span>Produk</span>
                    <strong>{{ $display_name }}</strong>
                </div>
                <div class="summary-row">
                    <span>Total Bayar</span>
                    <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                </div>
            </div>

            <div class="action-stack">
                <a href="{{ $qr_url }}" download="qris-{{ $transaction->order_id }}.png" class="action-btn action-btn-primary">Unduh QR Code</a>
                <button type="button" class="action-btn action-btn-secondary" id="shareButton">Bagikan QR Code</button>
            </div>

            <div class="small-note">
                <i class="fas fa-shield-alt"></i> Pembayaran terpercaya • Powered by Midtrans
            </div>
        </div>
    </div>
</div>

<script>
    const statusUrl = @json(route('payment.qris.status', ['orderId' => $transaction->order_id]));
    const redirectUrl = @json(url('/home'));
    const expiresAt = new Date(@json(str_replace(' ', 'T', $expires_at)));
    const countdownElement = document.getElementById('countdown');
    const statusBadge = document.getElementById('statusBadge');
    const statusMessage = document.getElementById('statusMessage');
    const qrImage = document.getElementById('qrImage');
    const shareButton = document.getElementById('shareButton');

    function setStatus(status, message) {
        statusBadge.className = 'status-pill status-' + status;
        statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        if (message) {
            statusMessage.textContent = message;
        }
    }

    function updateCountdown() {
        const now = new Date();
        const diff = expiresAt.getTime() - now.getTime();

        if (diff <= 0) {
            countdownElement.textContent = '00:00:00';
            setStatus('gagal', 'Waktu pembayaran QRIS telah habis.');
            return false;
        }

        const hours = String(Math.floor(diff / 3600000)).padStart(2, '0');
        const minutes = String(Math.floor((diff % 3600000) / 60000)).padStart(2, '0');
        const seconds = String(Math.floor((diff % 60000) / 1000)).padStart(2, '0');
        countdownElement.textContent = `${hours}:${minutes}:${seconds}`;

        return true;
    }

    async function checkStatus() {
        try {
            const response = await fetch(statusUrl, {
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                return;
            }

            const result = await response.json();
            if (!result.status) {
                return;
            }

            if (result.status === 'berhasil') {
                setStatus('berhasil', 'Pembayaran terdeteksi berhasil. Anda akan dialihkan ke halaman utama.');
                setTimeout(() => {
                    window.location.href = result.redirect_url || redirectUrl;
                }, 1800);
            } else if (result.status === 'gagal') {
                setStatus('gagal', 'Pembayaran QRIS gagal atau kedaluwarsa.');
            } else {
                setStatus('diproses', 'Menunggu pembayaran.');
            }
        } catch (error) {
            console.error(error);
        }
    }

    shareButton.addEventListener('click', async () => {
        try {
            if (navigator.share) {
                await navigator.share({
                    title: 'QRIS Getpulsa',
                    text: 'Silakan scan QR code ini untuk membayar.',
                    url: qrImage.src
                });
                return;
            }

            await navigator.clipboard.writeText(qrImage.src);
            alert('Link QR code berhasil disalin.');
        } catch (error) {
            alert('Bagikan QR code tidak tersedia di perangkat ini.');
        }
    });

    updateCountdown();
    const countdownTimer = setInterval(() => {
        const stillActive = updateCountdown();
        if (!stillActive) {
            clearInterval(countdownTimer);
        }
    }, 1000);

    checkStatus();
    const pollingTimer = setInterval(async () => {
        await checkStatus();
    }, 5000);
</script>
</body>
</html>
@include('footer')
