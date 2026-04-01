@include ('header')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        }

        .profile-card {
            max-width: 600px;
            width: 100%;
            background: #ffffff;
            border-radius: 2rem;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.12);
            overflow: hidden;
            transition: transform 0.2s;
        }

        .profile-card:hover {
            transform: translateY(-2px);
        }

        .profile-header {
            background: linear-gradient(135deg, #c90000, #a50000);
            padding: 2rem;
            text-align: center;
            color: white;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
            font-weight: bold;
            backdrop-filter: blur(4px);
        }

        .profile-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .profile-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #1e2f41;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.2s;
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
            padding: 0.75rem 1.5rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            transition: background 0.2s;
        }

        .btn-update:hover {
            background: #a50000;
        }

        .alert {
            padding: 0.75rem 1rem;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
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

        .text-muted {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }

        hr {
            margin: 1rem 0;
            border-color: #eef2f8;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 1rem;
            color: #c90000;
            text-decoration: none;
            font-weight: 500;
        }

        .back-link i {
            margin-right: 0.5rem;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            .profile-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
<div class="profile-card">
    <div class="profile-header">
        <div class="profile-avatar">
            {{ strtoupper(substr($user->nama, 0, 1)) }}
        </div>
        <h2>Profil Saya</h2>
        <p style="opacity:0.8; font-size:0.9rem;">Edit informasi akun Anda</p>
    </div>

    <div class="profile-body">
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

        <form method="POST" action="/profile/update">
            @csrf

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->nama) }}" required>
            </div>

            <hr>

            <button type="submit" class="btn-update">
                 Simpan Perubahan
            </button>
        </form>

        <hr>

        <a href="/home" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>
</body>
</html>
@include('footer')
