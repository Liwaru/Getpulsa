@include('header')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <title>Pembayaran Paket Data</title>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        /* CSS sama seperti sebelumnya, tidak perlu diubah */
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
            max-width: 800px;
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

        .payment-header {
            background: #f8fafd;
            border-radius: 1.5rem;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid #eef2f8;
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .amount {
            font-size: 1.2rem;
            font-weight: 700;
            color: #c90000;
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
            background: #fefefe;
            border-radius: 1rem;
            padding: 1rem;
            border: 1px solid #edf2f7;
        }

        .method-section .section-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #1e2f41;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .method-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .method-item {
            background: #f8fafd;
            border: 1px solid #eef2f8;
            border-radius: 1rem;
            padding: 0.75rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .method-item.active {
            border-color: #c90000;
            background: #fff0f0;
            box-shadow: 0 2px 8px rgba(201, 0, 0, 0.1);
        }

        .method-item img {
            width: 48px;
            height: 48px;
            object-fit: contain;
            margin-bottom: 0.5rem;
            border-radius: 12px;
        }

        .method-item span {
            display: block;
            font-weight: 500;
            font-size: 0.8rem;
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
        }

        .summary-card {
            background: #f8fafd;
            border-radius: 1rem;
            padding: 1rem;
            margin: 1.5rem 0;
            border: 1px solid #eef2f8;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: #5e6f8d;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-weight: 700;
            font-size: 1.2rem;
            margin-top: 0.5rem;
            padding-top: 0.5rem;
            border-top: 1px solid #e2e8f0;
            color: #1e2f41;
        }

        .btn-bayar {
            background: #c90000;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 40px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.15s;
            width: 100%;
        }

        .btn-bayar:hover {
            background: #a50000;
        }

        .hidden-group {
            display: none;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            .dashboard-inner {
                padding: 1rem;
            }
            .method-item img {
                width: 40px;
                height: 40px;
            }
        }
    </style>
</head>
<body>
<div class="white-dashboard">
    <div class="dashboard-inner">
        <div class="payment-header">
            <div class="phone-number">
                <i class="fas fa-phone-alt"></i>
                <span>{{ $no_hp }}</span>
            </div>
            <div class="amount">
                Rp{{ number_format($total, 0, ',', '.') }}
            </div>
        </div>

        <div class="method-title-main">Metode Pembayaran</div>

        <form id="paymentForm" action="{{ route('process.kuota.purchase') }}" method="POST">
    @csrf
    <input type="hidden" name="id_kuota" value="{{ $id_kuota }}">
    <input type="hidden" name="payment_method" id="paymentMethod" value="">
    <input type="hidden" name="account_number" id="accountNumberInput">

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
                <div class="input-group" id="ewalletInputGroup">
                    <label for="ewalletNumber">Nomor E-wallet</label>
                    <input type="text" id="ewalletNumber" autocomplete="off">
                </div>
            </div>

            <!-- Virtual Account -->
            <div class="method-section" id="vaSection">
                <div class="section-title">
                    <i class="fas fa-university" style="color:#c90000;"></i> Virtual Account (VA)
                </div>
                <div class="method-grid" id="vaGrid">
                    <div class="method-item" data-type="va" data-name="mandiri">
                        <img src="{{ asset('images/mandiri.png') }}" alt="Mandiri">
                        <span>Mandiri</span>
                    </div>
                    <div class="method-item" data-type="va" data-name="bca">
                        <img src="{{ asset('images/bca.png') }}" alt="BCA">
                        <span>BCA</span>
                    </div>
                    <div class="method-item" data-type="va" data-name="bni">
                        <img src="{{ asset('images/bni.png') }}" alt="BNI">
                        <span>BNI</span>
                    </div>
                </div>
                <div class="input-group" id="vaInputGroup">
                    <label for="vaNumber">Nomor Rekening</label>
                    <input type="text" id="vaNumber" autocomplete="off">
                </div>
            </div>

            <!-- Ringkasan Pembayaran -->
            <div class="summary-card">
                <div class="summary-item">
                    <span>Paket Data {{ $kuota }}</span>
                    <span>Rp{{ number_format($harga, 0, ',', '.') }}</span>
                </div>
                <div class="summary-total">
                    <span>Total Bayar</span>
                    <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            <button type="submit" class="btn-bayar">Bayar Sekarang</button>
        </form>
    </div>
</div>

<script>
    // JavaScript sama seperti sebelumnya (untuk pemilihan metode)
    const ewalletItems = document.querySelectorAll('#ewalletGrid .method-item');
    const vaItems = document.querySelectorAll('#vaGrid .method-item');
    const ewalletInputGroup = document.getElementById('ewalletInputGroup');
    const vaInputGroup = document.getElementById('vaInputGroup');
    const ewalletInput = document.getElementById('ewalletNumber');
    const vaInput = document.getElementById('vaNumber');
    const paymentMethodHidden = document.getElementById('paymentMethod');
    const accountNumberHidden = document.getElementById('accountNumberInput');
    const ewalletLabel = document.querySelector('#ewalletInputGroup label');

    let selectedType = null;
    let selectedName = null;

    ewalletInputGroup.classList.add('hidden-group');
    vaInputGroup.classList.add('hidden-group');

    function clearActive() {
        ewalletItems.forEach(item => item.classList.remove('active'));
        vaItems.forEach(item => item.classList.remove('active'));
    }

    function updateHidden() {
        if (selectedType && selectedName) {
            paymentMethodHidden.value = selectedType + '_' + selectedName;
        } else {
            paymentMethodHidden.value = '';
        }

        if (selectedType === 'e-wallet') {
            accountNumberHidden.value = ewalletInput.value;
        } else if (selectedType === 'va') {
            accountNumberHidden.value = vaInput.value;
        } else {
            accountNumberHidden.value = '';
        }
    }

    function handleMethodClick(method, type, name) {
        clearActive();
        method.classList.add('active');
        selectedType = type;
        selectedName = name;

        if (type === 'e-wallet') {
            ewalletInputGroup.classList.remove('hidden-group');
            vaInputGroup.classList.add('hidden-group');

            let labelText = '';
            if (name === 'gopay') labelText = 'Nomor GoPay';
            else if (name === 'ovo') labelText = 'Nomor OVO';
            else if (name === 'dana') labelText = 'Nomor DANA';
            ewalletLabel.innerText = labelText;
        } else {
            ewalletInputGroup.classList.add('hidden-group');
            vaInputGroup.classList.remove('hidden-group');
        }
        updateHidden();
    }

    ewalletItems.forEach(method => {
        method.addEventListener('click', () => {
            handleMethodClick(method, 'e-wallet', method.getAttribute('data-name'));
        });
    });

    vaItems.forEach(method => {
        method.addEventListener('click', () => {
            handleMethodClick(method, 'va', method.getAttribute('data-name'));
        });
    });

    ewalletInput.addEventListener('input', updateHidden);
    vaInput.addEventListener('input', updateHidden);

    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        if (!selectedType || !selectedName) {
            e.preventDefault();
            alert('Silakan pilih metode pembayaran terlebih dahulu.');
            return;
        }
        if ((selectedType === 'e-wallet' && ewalletInput.value.trim() === '') ||
            (selectedType === 'va' && vaInput.value.trim() === '')) {
            e.preventDefault();
            alert('Silakan isi nomor ' + (selectedType === 'e-wallet' ? ewalletLabel.innerText.toLowerCase() : 'rekening') + ' Anda.');
            return;
        }
        updateHidden();
    });
</script>
</body>
</html>
@include('footer')