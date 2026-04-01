@include('header')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <title>Tambah Pulsa</title>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        /* CSS tetap sama seperti sebelumnya */
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
        .phone-header {
            background: #f8fafd;
            border-radius: 1.5rem;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid #eef2f8;
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
        .pulsa-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-top: 1rem;
        }
        .pulsa-card {
            background: #ffffff;
            border: 1px solid #edf2f7;
            border-radius: 1.5rem;
            padding: 1.2rem;
            text-align: center;
            transition: all 0.2s;
            cursor: pointer;
        }
        .pulsa-card:hover {
            border-color: #c90000;
            box-shadow: 0 8px 18px rgba(201, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        .pulsa-nominal {
            font-weight: 800;
            font-size: 1.2rem;
            color: #e63946;
            margin-bottom: 8px;
        }
        .btn-beli-pulsa-now {  /* kelas baru */
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
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-beli-pulsa-now:hover {
            background: #a50000;
        }
        .no-data {
            text-align: center;
            padding: 3rem;
            color: #8f9bb3;
        }
        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            .dashboard-inner {
                padding: 1rem;
            }
            .pulsa-list {
                gap: 0.75rem;
            }
        }
    </style>
</head>
<body>
<div class="white-dashboard">
    <div class="dashboard-inner">
        <div class="phone-header">
            <div class="phone-number">
                <i class="fas fa-phone-alt"></i>
                <span>{{ $no_hp_user }}</span>
            </div>
        </div>

        <h3 style="margin-bottom: 1rem;">Pilih Nominal Pulsa</h3>
        <div class="pulsa-list">
            @forelse($pulsaList as $pulsa)
                <div class="pulsa-card">
                    <div class="pulsa-nominal">Rp{{ number_format($pulsa->pulsa, 0, ',', '.') }}</div>
                    <a href="{{ route('payment', ['id_pulsa' => $pulsa->id_pulsa]) }}" class="btn-beli-pulsa-now">Beli</a>
                </div>
            @empty
                <div class="no-data">Belum ada data pulsa</div>
            @endforelse
        </div>
    </div>
</div>
</body>
</html>
@include('footer')