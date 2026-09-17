@extends('layouts.admin')

@section('title', 'Detail Film')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Film</h1>
        <a href="{{ route('admin.film.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-center mb-3">
                    <img src="{{ asset('storage/' . $film->poster) }}" alt="{{ $film->title }}"
                        style="width: 100%; max-width: 220px; aspect-ratio: 2 / 3; object-fit: cover;"
                        class="rounded shadow-sm">
                </div>
                <div class="col-md-9">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th style="width: 160px;">Judul</th>
                            <td>: {{ $film->title }}</td>
                        </tr>
                        <tr>
                            <th>Genre</th>
                            <td>: {{ $film->genre }}</td>
                        </tr>
                        <tr>
                            <th>Durasi</th>
                            <td>: {{ $film->duration }} menit</td>
                        </tr>
                        <tr>
                            <th class="align-top">Sinopsis</th>
                            <td>: {{ $film->synopsis }}</td>
                        </tr>
                    </table>

                    <div class="mt-4">
                        <a href="{{ route('admin.film.edit', $film) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Ubah
                        </a>
                        <form action="{{ route('admin.film.destroy', $film) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Hapus film ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection