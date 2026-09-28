@extends('layouts.admin')

@section('title', 'Ubah Profil')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Ubah Profil</h1>

    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow mb-4">
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="text-center mb-4">
                            <img id="preview-photo"
                                src="{{ $admin->profile_photo ? asset('storage/' . $admin->profile_photo) : asset('img/undraw_profile.svg') }}"
                                alt="Foto profil" class="rounded-circle mb-3"
                                style="width: 120px; height: 120px; object-fit: cover;">
                            <div>
                                <label for="profile_photo" class="btn btn-outline-secondary btn-sm mb-0">
                                    <i class="fas fa-camera"></i> Ganti Foto
                                </label>
                                <input type="file" name="profile_photo" id="profile_photo" class="d-none"
                                    accept="image/png, image/jpeg">
                                <small class="form-text text-muted">JPG/PNG, maks 2MB.</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $admin->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ old('email', $admin->email) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <input type="password" name="password" id="password" class="form-control"
                                autocomplete="new-password">
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" autocomplete="new-password">
                        </div>

                        <button type="submit" class="btn btn-danger btn-block mt-4">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#profile_photo').on('change', function () {
            const file = this.files[0];
            if (file) {
                $('#preview-photo').attr('src', URL.createObjectURL(file));
            }
        });
    </script>

    @if (Session::has('success'))
        <script>
            Swal.fire({ title: "Berhasil!", text: @json(Session::get('success')), icon: "success" });
        </script>
    @endif
@endpush