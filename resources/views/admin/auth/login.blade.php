<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login Admin - Cinevo</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,800,900" rel="stylesheet">
    <link href="{{ asset('css/custom-admin.css') }}" rel="stylesheet">
</head>
<body class="cinevo-admin-login">
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-logo">
                <img src="{{ asset('img/logo.png') }}" alt="Cinevo">
            </div>

            <h1>Login Admin</h1>
            <p class="login-subtitle">Masuk ke halaman administrasi Cinevo</p>

            @if ($errors->any())
                <div class="login-alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.store') }}">
                @csrf

                <div class="login-form-group">
                    <label for="email">Email</label>
                    <div class="login-input">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Masukkan email" required autofocus>
                    </div>
                </div>

                <div class="login-form-group">
                    <label for="password">Password</label>
                    <div class="login-input">
                        <input type="password" name="password" id="password" placeholder="Masukkan password" required>
                    </div>
                </div>

                <div class="login-remember">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember Me</label>
                </div>

                <button type="submit" class="login-button"> Login </button>
            </form>
        </div>
    </div>
</body>
</html>