@extends('layouts.admin')

@section('title', 'Detail Jadwal Tayang')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Jadwal Tayang</h1>
        <a href="{{ route('admin.showtime.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <img src="{{ asset('storage/' . $showtime->film->poster) }}" alt="{{ $showtime->film->title }}"
                        class="img-fluid rounded">
                </div>
                <div class="col-md-9">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 180px;">Film</th>
                            <td>: {{ $showtime->film->title }}</td>
                        </tr>
                        <tr>
                            <th>Studio</th>
                            <td>: {{ $showtime->studio->name }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Tayang</th>
                            <td>: {{ \Carbon\Carbon::parse($showtime->date)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th>Jam Tayang</th>
                            <td>: {{ \Carbon\Carbon::parse($showtime->time)->format('H:i') }} WIB</td>
                        </tr>
                        <tr>
                            <th>Harga Tiket</th>
                            <td>: Rp{{ number_format($showtime->price, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                    <div class="mt-4">
                        <a href="{{ route('admin.showtime.edit', $showtime) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Ubah
                        </a>
                        <form action="{{ route('admin.showtime.destroy', $showtime) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Hapus jadwal tayang ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection