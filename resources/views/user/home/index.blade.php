@extends('layouts.user')

@section('title', 'Cinevo - Nonton Film Favoritmu')

@section('content')

<style>
    .carousel {
    max-width: 1100px;
    margin: 0 auto 40px;
}

.carousel-inner {
    border-radius: 10px;
    overflow: hidden;
}

.carousel-item img {
    width: 100%;
    height: 420px;
    object-fit: cover;
}

.carousel-control-prev,
.carousel-control-next {
    width: 50px;
    height: 50px;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgb(216, 44, 159);
    border-radius: 50%;
    opacity: 1;
}

.carousel-control-prev {
    left: -65px;
}

.carousel-control-next {
    right: -65px;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    filter: invert(1);
    width: 20px;
    height: 20px;
}

.carousel-indicators button {
    background-color: #dc3545;
}

@media (max-width: 1200px) {
    .carousel-control-prev {
        left: 10px;
    }

    .carousel-control-next {
        right: 10px;
    }
}
</style>

<div class="container">

    {{-- Banner / Carousel --}}
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="{{ asset('img/poster1.jpg') }}" class="d-block w-100" alt="Poster 1">
      <div class="carousel-caption d-none d-md-block">
        <h5>First slide label</h5>
        <p>Some representative placeholder content for the first slide.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="{{ asset('img/poster2.jpg') }}" class="d-block w-100" alt="Poster 2">
      <div class="carousel-caption d-none d-md-block">
        <h5>Second slide label</h5>
        <p>Some representative placeholder content for the second slide.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="{{ asset('img/poster3.jpeg') }}" class="d-block w-100" alt="Poster 3">
      <div class="carousel-caption d-none d-md-block">
        <h5>Third slide label</h5>
        <p>Some representative placeholder content for the third slide.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
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
                        <a href="{{ route('film.show', $film->id) }}" class="btn btn-outline-danger btn-sm w-100">Lihat Detail</a>
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