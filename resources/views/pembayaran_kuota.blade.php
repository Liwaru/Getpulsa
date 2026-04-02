@include('header')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Pembayaran Paket Data</title>
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

        .payment-form {
            display: grid;
            gap: 1rem;
        }

        .form-section,
        .summary-section {
            background: #fff;
            border: 1px solid #edf2f7;
            border-radius: 1.25rem;
            padding: 1.25rem;
        }

        .section-heading {
            font-size: 1rem;
            font-weight: 700;
            color: #1e2f41;
            margin-bottom: 1rem;
        }

        .field-label {
            display: block;
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

        .summary-row {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.65rem 0;
            color: #425466;
            border-bottom: 1px solid #eef2f8;
        }

        .summary-row:last-of-type {
            border-bottom: none;
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
            }

            .payment-inner {
                padding: 1.25rem;
            }

            .summary-row,
            .summary-total {
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
<div class="payment-card">
    <div class="payment-inner">
        <div class="payment-top">
            <div class="payment-title">
                
                <span>Pembayaran Paket Data</span>
            </div>
            <div class="payment-subtitle">
                Masukkan nomor tujuan untuk pembelian paket data ini.
            </div>
        </div>

        <form class="payment-form" action="{{ route('process.kuota.purchase') }}" method="POST">
            @csrf
            <input type="hidden" name="id_kuota" value="{{ $id_kuota }}">
            <input type="hidden" name="payment_method" value="kuota">

            <div class="form-section">
                <div class="section-heading">Nomor Tujuan</div>
                <label class="field-label" for="account_number">Nomor untuk isi kuota</label>
                <input
                    class="field-input"
                    type="text"
                    id="account_number"
                    name="account_number"
                    value="{{ old('account_number', $no_hp) }}"
                    placeholder="Masukkan nomor tujuan"
                    inputmode="numeric"
                    pattern="[0-9]+"
                    required
                >
                <div class="field-help">Nomor ini akan digunakan sebagai tujuan pengaktifan paket data.</div>
            </div>

            <div class="summary-section">
                <div class="section-heading">Ringkasan Pembayaran</div>
                <div class="summary-row">
                    <span>Paket Data</span>
                    <span>{{ $kuota }}</span>
                </div>
                <div class="summary-row">
                    <span>Harga</span>
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
</body>
</html>
@include('footer')
