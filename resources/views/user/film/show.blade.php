@extends('layouts.user')

@section('title', $film->title . ' - Cinevo')

@section('content')
<div class="container">
    <div class="row g-4">
        <div class="col-md-4">
            <img src="{{ $film->poster ? asset('storage/'.$film->poster) : 'https://placehold.co/400x600?text=Poster' }}"
                class="img-fluid rounded shadow-sm" alt="{{ $film->title }}">
        </div>
        <div class="col-md-8">
            <h3 class="fw-bold">{{ $film->title }}</h3>
            <p class="text-muted mb-1">{{ $film->genre }} · {{ $film->duration }} menit</p>
            <p class="mt-3">{{ $film->synopsis }}</p>
        </div>
    </div>

    <hr class="my-4">

    <h5 class="fw-bold mb-3">Pilih Jadwal Tayang</h5>

    @if ($film->showtimes->isEmpty())
        <p class="text-muted">Belum ada jadwal tayang untuk film ini.</p>
    @else
        <div class="row g-3">
            @foreach ($film->showtimes as $showtime)
                <div class="col-6 col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <p class="mb-1 fw-semibold">{{ \Carbon\Carbon::parse($showtime->date)->translatedFormat('d M Y') }}</p>
                            <p class="mb-1">{{ \Carbon\Carbon::parse($showtime->time)->format('H:i') }}</p>
                            <p class="mb-2 small text-muted">Studio {{ $showtime->studio->name ?? '-' }}</p>
                            <p class="mb-2 fw-semibold">Rp{{ number_format($showtime->price, 0, ',', '.') }}</p>
                            <a href="#" class="btn btn-danger btn-sm w-100" style="background-color:#f6b8b8; border:none;">
                                Pilih Kursi
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection