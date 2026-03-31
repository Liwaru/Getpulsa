<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #ffffff;
            height: 100vh;
        }
        .register-card {
            max-width: 400px;
            margin: auto;
            margin-top: 100px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="register-card bg-white">

        <h4 class="text-center mb-4 fw-bold">Register</h4>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/aksi_register">
            @csrf

            <!-- Nama -->
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <!-- No HP -->
            <div class="mb-3">
                <label>No HP</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <!-- Captcha -->
            <div class="mb-3">
                <label>
                    Berapa {{ session('num1') }} + {{ session('num2') }} ?
                </label>
                <input type="text" name="captcha" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Register
            </button>

            <!-- Link ke login -->
            <div class="text-center mt-3">
                <small class="text-muted">
                    Sudah punya akun? 
                    <a href="/login" class="text-primary fw-semibold text-decoration-none">Login di sini</a>
                </small>
            </div>

        </form>

    </div>
</div>

</body>
</html>