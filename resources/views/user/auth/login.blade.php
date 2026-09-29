@extends('layouts.user')

@section('title', 'Login Page - Cinevo')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-9">
            <div class="card border-0 shadow-lg my-5">
                <div class="card-body p-5">
                    <div class="text-center">
                        <h1 class="h4 text-white mb-4">Login page!</h1>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Enter Email Address..." required>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter Your Password..." required>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                        <div class="login-remember">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">Remember Me</label>
                        </div>

                        <div class="row mb-3">
                        <button type="submit" class="login-button"> Login </button>

                        <div class="login-register">
                            Belum punya akun? <a href="{{ route('register') }}">Regis</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection