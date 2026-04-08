@include('header')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Pembayaran Pulsa</title>
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
            padding-left: calc(280px + 1.5rem);
        }

        .payment-card {
            width: 100%;
            max-width: 720px;
            margin-top: 2rem;
            background: #fff;
            border-radius: 2rem;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.12);
            overflow: hidden;
        }

        .payment-inner {
            padding: 2rem;
        }

        .payment-top {
            background: #f8fafd;
            border: 1px solid #eef2f8;
            border-radius: 1.5rem;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .payment-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.2rem;
            font-weight: 700;
            color: #1e2f41;
            margin-bottom: 0.4rem;
        }

        .payment-title i {
            color: #c90000;
        }

        .payment-subtitle {
            color: #5e6f8d;
            font-size: 0.95rem;
        }

        .method-title-main {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #1e2f41;
            border-left: 4px solid #c90000;
            padding-left: 0.75rem;
        }

        .method-section {
            margin-bottom: 2rem;
            background: linear-gradient(180deg, #ffffff 0%, #fbfcff 100%);
            border-radius: 1.25rem;
            padding: 1.15rem;
            border: 1px solid #e7edf5;
        }

        .method-section .section-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 1.05rem;
            color: #1e2f41;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .method-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.9rem;
        }

        .method-item {
            background: linear-gradient(180deg, #f9fbff 0%, #f3f7fc 100%);
            border: 1px solid #dfe8f2;
            border-radius: 1.1rem;
            padding: 0.95rem 0.75rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            min-height: 118px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .method-item.active {
            border-color: #c90000;
            background: linear-gradient(180deg, #fff4f4 0%, #ffeaea 100%);
            box-shadow: 0 10px 24px rgba(201, 0, 0, 0.14);
            transform: translateY(-2px);
        }

        .method-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 47, 65, 0.1);
        }

        .method-item img {
            width: 52px;
            height: 52px;
            object-fit: contain;
            margin-bottom: 0.65rem;
            border-radius: 12px;
        }

        .method-item span {
            display: block;
            font-weight: 700;
            font-size: 0.84rem;
            color: #1e2f41;
        }

        .method-item .method-subtitle {
            font-size: 0.72rem;
            font-weight: 500;
            color: #6b7b8f;
            margin-top: 0.22rem;
        }

        .input-group {
            margin-top: 0.5rem;
            transition: all 0.2s;
        }

        .input-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
            color: #1e2f41;
        }

        .input-group input {
            width: 100%;
            padding: 0.6rem 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            color: #1e2f41;
            margin-bottom: 0.5rem;
        }

        .field-input {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1px solid #d9e2ec;
            border-radius: 0.9rem;
            font-size: 1rem;
            font-family: inherit;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .field-input:focus {
            border-color: #c90000;
            box-shadow: 0 0 0 4px rgba(201, 0, 0, 0.08);
        }

        .field-help {
            margin-top: 0.5rem;
            font-size: 0.82rem;
            color: #6b7c93;
        }

        .summary-card {
            background: #f8fafd;
            border: 1px solid #eef2f8;
            border-radius: 1.25rem;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            color: #425466;
            border-bottom: 1px solid #eef2f8;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            margin-top: 0.75rem;
            padding-top: 1rem;
            border-top: 1px solid #dbe5f0;
            font-size: 1.15rem;
            font-weight: 800;
            color: #1e2f41;
        }

        .small-note {
            font-size: 0.7rem;
            color: #b90000;
            margin-top: 1.5rem;
            text-align: center;
        }

        .btn-bayar {
            width: 100%;
            border: none;
            border-radius: 999px;
            background: #c90000;
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
            padding: 0.95rem 1.25rem;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .btn-bayar:hover {
            background: #a50000;
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
                padding-left: 1rem;
            }

            .payment-inner {
                padding: 1.25rem;
            }

            .method-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .method-item img {
                width: 40px;
                height: 40px;
            }
        }

        @media (min-width: 769px) {
            .payment-card {
                max-width: min(720px, calc(100vw - 280px - 3rem));
            }
        }
    </style>
</head>
<body>
<div class="payment-card">
    <div class="payment-inner">
        <div class="payment-top">
            <div class="payment-title">
                <span>Pembayaran Pulsa</span>
            </div>
            <div class="payment-subtitle">
                Isi nomor tujuan pulsa lalu lanjutkan pembayaran.
            </div>
        </div>

        <div class="method-title-main">Metode Pembayaran</div>

        <form
            id="paymentForm"
            action="{{ route('process.payment') }}"
            method="POST"
            data-finish-url="{{ route('midtrans.finish') }}"
            data-redirect-url="{{ url('/home') }}"
            data-qris-url="{{ route('payment.qris.create') }}"
            data-item-type="pulsa"
        >
            @csrf
            <input type="hidden" name="id_pulsa" value="{{ $id_pulsa }}">
            <input type="hidden" id="paymentMethod" name="payment_method" value="">
            <input type="hidden" id="accountNumberInput" name="account_number" value="">

            <!-- QRIS -->
            <div class="method-section">
                <div class="section-title">
                    <i class="fas fa-qrcode" style="color:#c90000;"></i> QRIS
                </div>
                <div class="method-grid" id="qrisGrid">
                    <div class="method-item" data-type="qris" data-name="qris">
                        <i class="fas fa-qrcode" style="font-size: 2rem; color:#c90000; margin-bottom: 0.5rem;"></i>
                        <span>QRIS</span>
                        <div class="method-subtitle">Scan QR</div>
                    </div>
                </div>
            </div>

            <!-- Dompet Digital -->
            <div class="method-section" id="ewalletSection">
                <div class="section-title">
                    <i class="fas fa-wallet" style="color:#c90000;"></i> E-wallet
                </div>
                <div class="method-grid" id="ewalletGrid">
                    <div class="method-item" data-type="e-wallet" data-name="gopay">
                        <img src="{{ asset('images/gopay.png') }}" alt="GoPay">
                        <span>GoPay</span>
                    </div>
                    <div class="method-item" data-type="e-wallet" data-name="ovo">
                        <img src="{{ asset('images/ovo.png') }}" alt="OVO">
                        <span>OVO</span>
                    </div>
                    <div class="method-item" data-type="e-wallet" data-name="dana">
                        <img src="{{ asset('images/dana.png') }}" alt="DANA">
                        <span>DANA</span>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Pembayaran -->
            <div class="summary-card">
                <div class="summary-item">
                    <span>Pulsa {{ number_format($nominal, 0, ',', '.') }}</span>
                    <span>Rp{{ number_format($nominal, 0, ',', '.') }}</span>
                </div>
                <div class="summary-total">
                    <span>Total Bayar</span>
                    <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            <button type="submit" class="btn-bayar" id="payButton">Bayar Sekarang</button>
        </form>

        <div class="small-note">
            <i class="fas fa-shield-alt"></i> Pembayaran terpercaya • Powered by Midtrans
        </div>
    </div>
</div>

<script
    src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
    data-client-key="{{ $midtrans_client_key }}"
></script>
<script>
    const paymentForm = document.getElementById('paymentForm');
    const qrisItems = document.querySelectorAll('#qrisGrid .method-item');
    const ewalletItems = document.querySelectorAll('#ewalletGrid .method-item');
    const paymentMethodHidden = document.getElementById('paymentMethod');
    const accountNumberHidden = document.getElementById('accountNumberInput');
    const payButton = document.getElementById('payButton');

    let selectedType = null;
    let selectedName = null;

    function clearActive() {
        qrisItems.forEach(item => item.classList.remove('active'));
        ewalletItems.forEach(item => item.classList.remove('active'));
    }

    function updateHidden() {
        if (selectedType === 'qris') {
            paymentMethodHidden.value = 'qris';
        } else if (selectedName) {
            paymentMethodHidden.value = 'e-wallet_' + selectedName;
        } else {
            paymentMethodHidden.value = '';
        }
        accountNumberHidden.value = '';
    }

    function handleQrisClick(method) {
        clearActive();
        method.classList.add('active');
        selectedType = 'qris';
        selectedName = 'qris';
        updateHidden();
    }

    function handleMethodClick(method, name) {
        clearActive();
        method.classList.add('active');
        selectedType = 'e-wallet';
        selectedName = name;
        updateHidden();
    }

    qrisItems.forEach(method => {
        method.addEventListener('click', () => handleQrisClick(method));
    });

    ewalletItems.forEach(method => {
        method.addEventListener('click', () => handleMethodClick(method, method.getAttribute('data-name')));
    });

    async function syncMidtransResult(orderId) {
        if (!orderId) return;
        await fetch(paymentForm.dataset.finishUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ order_id: orderId })
        });
    }

    function redirectAfterPayment(message) {
        if (message) alert(message);
        window.location.href = paymentForm.dataset.redirectUrl;
    }

    paymentForm.addEventListener('submit', async function(e) {
        if (!selectedName) {
            e.preventDefault();
            alert('Silakan pilih metode pembayaran terlebih dahulu.');
            return;
        }
        e.preventDefault();
        updateHidden();

        payButton.disabled = true;
        payButton.innerText = 'Memproses...';

        try {
            const targetUrl = selectedType === 'qris'
                ? paymentForm.dataset.qrisUrl
                : paymentForm.action;

            const payload = selectedType === 'qris'
                ? (() => {
                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('payment_type', paymentForm.dataset.itemType);
                    formData.append('item_id', '{{ $id_pulsa }}');
                    return formData;
                })()
                : new FormData(paymentForm);

            const response = await fetch(targetUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: payload
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || 'Gagal membuat transaksi Midtrans.');
            }

            if (selectedType === 'qris') {
                if (!result.redirect_url) throw new Error('Halaman QRIS tidak berhasil dibuat.');
                window.location.href = result.redirect_url;
                return;
            }

            if (!result.snap_token) throw new Error('Snap token tidak tersedia.');

            window.snap.pay(result.snap_token, {
                onSuccess: async function(response) {
                    await syncMidtransResult(response.order_id || result.order_id);
                    redirectAfterPayment('Pembayaran berhasil.');
                },
                onPending: async function(response) {
                    await syncMidtransResult(response.order_id || result.order_id);
                    redirectAfterPayment('Pembayaran sedang diproses.');
                },
                onError: function(response) {
                    console.error(response);
                    alert('Pembayaran gagal diproses oleh Midtrans.');
                },
                onClose: function() {
                    redirectAfterPayment('Popup pembayaran ditutup sebelum transaksi selesai.');
                }
            });
        } catch (error) {
            alert(error.message || 'Terjadi kesalahan saat memproses pembayaran.');
        } finally {
            payButton.disabled = false;
            payButton.innerText = 'Bayar Sekarang';
        }
    });
</script>
</body>
</html>
@include('footer')
