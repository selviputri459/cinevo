@extends('layouts.admin')

@section('title', 'Ubah Film')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Film</h1>
        <a href="{{ route('admin.film.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.film.update', $film) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Judul Film</label>
                    <input type="text" name="title" id="title" class="form-control"
                        value="{{ old('title', $film->title) }}" required>
                </div>

                <div class="form-group">
                    <label for="genre">Genre</label>
                    <input type="text" name="genre" id="genre" class="form-control"
                        value="{{ old('genre', $film->genre) }}" required>
                </div>

                <div class="form-group">
                    <label for="duration">Durasi (menit)</label>
                    <input type="number" name="duration" id="duration" class="form-control" min="1"
                        value="{{ old('duration', $film->duration) }}" required>
                </div>

                <div class="form-group">
                    <label for="synopsis">Sinopsis</label>
                    <textarea name="synopsis" id="synopsis" rows="4" class="form-control" required>{{ old('synopsis', $film->synopsis) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Poster Saat Ini</label><br>
                    <img src="{{ asset('storage/' . $film->poster) }}" alt="{{ $film->title }}"
                        style="width: 100px; height: 150px; object-fit: cover;" class="rounded mb-2">
                </div>

                <div class="form-group">
                    <label for="poster">Ganti Poster (opsional)</label>
                    <input type="file" name="poster" id="poster" class="form-control-file" accept="image/*">
                    <small class="form-text text-muted">Kosongkan kalau tidak ingin mengganti poster. Format
                        JPG/PNG, maks 2MB.</small>
                </div>

                <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection