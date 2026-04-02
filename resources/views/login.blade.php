<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #ffffff;
            height: 100vh;
        }
        .login-card {
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
    <div class="login-card bg-white">

        <h4 class="text-center mb-4 fw-bold">Login</h4>

        <form method="POST" action="{{ url('/aksi_login') }}">
            @csrf

            <!-- No HP -->
            <div class="mb-3">
                <label>No HP</label>
                <input type="text" name="no_hp_user" class="form-control" required pattern="\d+" inputmode="numeric">
            </div>

            <!-- Captcha -->
            <div class="mb-3">
                <label>
                    Berapa {{ session('num1') }} + {{ session('num2') }} ?
                </label>
                <input type="text" name="captcha" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Login
            </button>

            <div class="text-center mt-3">
    <small class="text-muted">
        Belum punya akun? 
        <a href="/register" class="text-primary fw-semibold text-decoration-none">Daftar di sini</a>
    </small>
</div>

        </form>

    </div>
</div>

</body>
</html>
