@extends('layouts.user')

@section('title', 'Cinevo - Nonton Film Favoritmu')

@section('content')
<div class="container">

    {{-- Banner / Carousel --}}
    <div id="bannerCarousel" class="carousel slide rounded shadow-sm mb-5" data-bs-ride="carousel">
        <div class="carousel-inner rounded" style="height: 320px; background-color: #f6b8b8;">
            <div class="carousel-item active h-100 d-flex align-items-center justify-content-center">
                <span class="text-white fw-semibold">Banner Promo</span>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    {{-- Sedang Tayang --}}
    <h4 id="sedang-tayang" class="fw-bold mb-3">Sedang Tayang</h4>
    <div class="row g-3 mb-5">
        @forelse ($sedangTayang as $film)
            <div class="col-6 col-md-3">
                <div class="card h-100 shadow-sm film-card">
                    <img src="{{ $film->poster ? asset('storage/'.$film->poster) : 'https://placehold.co/300x400?text=Poster' }}"
                        class="card-img-top" alt="{{ $film->title }}" style="height:220px; object-fit:cover;">
                    <div class="card-body p-2">
                        <p class="mb-1 small fw-semibold">{{ $film->title }}</p>
                        <p class="mb-1 small text-muted">{{ $film->genre }} · {{ $film->duration }} menit</p>
                        @if ($film->showtimes->isNotEmpty())
                            <p class="mb-2 fw-semibold">Rp{{ number_format($film->showtimes->first()->price, 0, ',', '.') }}</p>
                        @endif
                        <a href="{{ route('user.film.show', $film->id) }}" class="btn btn-outline-danger btn-sm w-100">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada film yang sedang tayang.</p>
        @endforelse
    </div>

    {{-- Segera Tayang --}}
    <h4 id="segera-tayang" class="fw-bold mb-3">Segera Tayang</h4>
    <div class="row g-3 mb-5">
        @forelse ($segeraTayang as $film)
            <div class="col-6 col-md-3">
                <div class="card h-100 shadow-sm film-card">
                    <img src="{{ $film->poster ? asset('storage/'.$film->poster) : 'https://placehold.co/300x400?text=Poster' }}"
                        class="card-img-top" alt="{{ $film->title }}" style="height:220px; object-fit:cover;">
                    <div class="card-body p-2">
                        <p class="mb-1 small fw-semibold">{{ $film->title }}</p>
                        <p class="mb-2 small text-muted">{{ $film->genre }} · {{ $film->duration }} menit</p>
                        <a href="{{ route('film.show', $film->id) }}" class="btn btn-outline-danger btn-sm w-100">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada film yang akan segera tayang.</p>
        @endforelse
    </div>

</div>
@endsection