@extends('layouts.user')

@section('title', 'Ubah Profil - Cinevo')

@section('content')

@push('styles')
<style>
    .profile-photo-section {
        text-align: center;
        margin-bottom: 28px;
    }

    .profile-photo-section img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        display: block;
        margin: 0 auto 14px;
        border: 2px solid var(--cinevo-border);
        background: var(--cinevo-panel);
    }

    .btn-photo {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 14px;
        border-radius: 7px;
        border: 1px solid var(--cinevo-pink);
        background: transparent;
        color: var(--cinevo-pink-light);
        font-size: .85rem;
        font-weight: 600;
        cursor: pointer;
        transition: .2s ease;
    }

    .btn-photo:hover {
        background: var(--cinevo-pink);
        color: var(--cinevo-bg-dark);
    }

    .profile-photo-section small {
        display: block;
        margin-top: 7px;
        color: var(--cinevo-muted);
        font-size: .75rem;
    }

    .btn-save {
        width: 100%;
        padding: 11px;
        border: 1px solid var(--cinevo-pink);
        border-radius: 9px;
        background: var(--cinevo-pink);
        color: var(--cinevo-bg-dark);
        font-weight: 700;
        cursor: pointer;
        transition: .2s ease;
    }

    .btn-save:hover {
        background: var(--cinevo-pink-light);
        border-color: var(--cinevo-pink-light);
    }

    .cinevo-muted {
        color: var(--cinevo-pink-light) !important;
        opacity: 0.85;
    }
</style>
@endpush

<div class="container">
    <div class="row justify-content-center py-5">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body p-4">

                    <div class="text-center mb-4">
                        <h5 class="mt-3 mb-0">Ubah Profil</h5>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="profile-photo-section">
                            <img id="preview-photo"
                                src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('img/undraw_profile.svg') }}"
                                alt="Foto profil">

                            <label for="profile_photo" class="btn-photo">
                                <i class="fas fa-camera"></i>
                                {{ $user->profile_photo ? 'Ganti Foto' : 'Tambah Foto' }}
                            </label>

                            <input type="file" name="profile_photo" id="profile_photo" accept="image/png, image/jpeg" hidden>
                            <small>JPG/PNG, maksimal 2MB</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password"> Password
                                <small class="cinevo-muted">(kosongkan kalau tidak diganti)</small>
                            </label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                        </div>
                        <button type="submit" class="btn-save"> Save </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection