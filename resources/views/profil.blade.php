@include('header')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <title>Profil Saya</title>
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
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            padding: 1.5rem;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-left: calc(280px + 1.5rem);
        }

        /* MAIN WHITE CARD (sama dengan dashboard) */
        .white-dashboard {
            max-width: 600px;
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
            padding: 2rem;
        }

        /* Profile header - tanpa gradient berlebihan, lebih clean */
        .profile-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #eb0000, #a50000);
            border-radius: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-weight: 600;
            font-size: 2rem;
            box-shadow: 0 6px 12px -6px rgba(0,0,0,0.1);
        }

        .profile-header h2 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #da0000;
            letter-spacing: -0.3px;
            margin-bottom: 0.25rem;
        }

        .profile-header p {
            font-size: 0.85rem;
            color: #5e6f8d;
        }

        /* Form styling */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #1e2f41;
            font-size: 0.9rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.2s;
            background: #ffffff;
        }

        .form-group input:focus {
            outline: none;
            border-color: #c90000;
            box-shadow: 0 0 0 3px rgba(201, 0, 0, 0.1);
        }

        .btn-update {
            background: #c90000;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            width: 100%;
            transition: background 0.2s, transform 0.1s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-update:hover {
            background: #a50000;
            transform: scale(0.98);
        }

        .alert {
            padding: 0.75rem 1rem;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        .alert-error {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }

        hr {
            margin: 1.5rem 0;
            border: none;
            border-top: 1px solid #eef2f8;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #c90000;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: opacity 0.2s;
        }

        .back-link:hover {
            opacity: 0.8;
            text-decoration: underline;
        }

        .text-muted {
            font-size: 0.7rem;
            color: #8f9bb3;
            margin-top: 0.25rem;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
                padding-left: 1rem;
            }
            .dashboard-inner {
                padding: 1.5rem;
            }
            .profile-avatar {
                width: 70px;
                height: 70px;
                font-size: 1.8rem;
            }
            .profile-header h2 {
                font-size: 1.3rem;
            }
        }

        @media (min-width: 769px) {
            .white-dashboard {
                max-width: min(600px, calc(100vw - 280px - 3rem));
            }
        }
    </style>
</head>
<body>
<div class="white-dashboard">
    <div class="dashboard-inner">
        <!-- Header profil -->
        <div class="profile-header">
            <div class="profile-avatar">
                {{ strtoupper(substr($user->nama, 0, 1)) }}
            </div>
            <h2>Profil Saya</h2>
            <p>Edit informasi akun Anda</p>
        </div>

        <!-- Notifikasi -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
            </div>
        @endif

        <!-- Form update profil -->
        <form method="POST" action="/profile/update">
            @csrf

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->nama) }}" required>
            </div>

            <button type="submit" class="btn-update">
               Simpan Perubahan
            </button>
        </form>

    </div>
</div>
</body>
</html>
@include('footer')
