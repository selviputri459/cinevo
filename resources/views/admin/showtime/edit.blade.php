@extends('layouts.admin')

@section('title', 'Ubah Jadwal Tayang')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Jadwal Tayang</h1>
        <a href="{{ route('admin.showtime.index') }}" class="btn btn-secondary btn-sm">
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

            <form action="{{ route('admin.showtime.update', $showtime) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="film_id" class="form-label">Film</label>
                    <select name="film_id" id="film_id" class="form-select @error('film_id') is-invalid @enderror">
                        <option value="">-- Pilih Film --</option>
                        @foreach ($films as $film)
                            <option value="{{ $film->id }}"
                                {{ old('film_id', $showtime->film_id) == $film->id ? 'selected' : '' }}>
                                {{ $film->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('film_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="studio_id" class="form-label">Studio</label>
                    <select name="studio_id" id="studio_id" class="form-select @error('studio_id') is-invalid @enderror">
                        <option value="">-- Pilih Studio --</option>
                        @foreach ($studios as $studio)
                            <option value="{{ $studio->id }}"
                                {{ old('studio_id', $showtime->studio_id) == $studio->id ? 'selected' : '' }}>
                                {{ $studio->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('studio_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">Tanggal Tayang</label>
                    <input type="date" name="date" id="date" value="{{ old('date', $showtime->date) }}"
                        class="form-control @error('date') is-invalid @enderror">
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="time" class="form-label">Jam Tayang</label>
                    <input type="time" name="time" id="time"
                        value="{{ old('time', \Carbon\Carbon::parse($showtime->time)->format('H:i')) }}"
                        class="form-control @error('time') is-invalid @enderror">
                    @error('time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Harga Tiket</label>
                    <input type="number" step="0.01" min="0" name="price" id="price"
                        value="{{ old('price', $showtime->price) }}"
                        class="form-control @error('price') is-invalid @enderror">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save fa-sm"></i> Perbarui
                </button>
            </form>
        </div>
    </div>
@endsection