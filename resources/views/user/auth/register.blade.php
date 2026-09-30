@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-7">
            <div class="card">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Register page!</h1>
                            </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                @csrf

                        <div class="profile-photo-section">
                            <img id="preview-photo" src="{{ asset('img/undraw_profile.svg') }}" alt="Foto profil">
                            <label for="profile_photo" class="btn-photo">
                                <i class="fas fa-camera"></i>
                                Tambah Foto
                            </label>
                            <input type="file" name="profile_photo" id="profile_photo" accept="image/png, image/jpeg" hidden>
                            <small>JPG/PNG, maksimal 2MB</small>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-danger">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <small>Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-photo-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        margin-bottom: 24px;
    }

    #preview-photo {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #eee;
    }

</style>

<script>
    document.getElementById('profile_photo').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            document.getElementById('preview-photo').src = URL.createObjectURL(file);
        }
    });
</script>

@endsection
