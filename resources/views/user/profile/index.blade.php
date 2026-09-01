@extends('layouts.user')

@section('title', 'Ubah Profil - Cinevo')

@section('content')
<div class="container">
    <div class="row justify-content-center py-5">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body p-4">

                    <div class="text-center mb-4">
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center"
                            style="width:80px; height:80px;">
                            <span class="fa fa-user fa-2x text-secondary"></span>
                        </div>
                        <h5 class="mt-3 mb-0">Ubah Profil</h5>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Password <small class="text-muted">(kosongkan kalau tidak diganti)</small></label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-danger btn-block w-100" style="background-color:#dceb0a; border:none;">
                            Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection