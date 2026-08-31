<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Regitrasi - cinevo</title>
</head>
<body>
    <h1>Registrasi - cinevo</h1>

    @if ($errors->any())
    <div>
        @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <form action="{{ route('register.store') }}" method='POST'>
        @csrf
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input type="password_confirmation" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit">Regis</button>
    </form>

    <p>Sudah punya akun?<a href="{{ route('login') }}">Login</a></p>
</body>
</html>