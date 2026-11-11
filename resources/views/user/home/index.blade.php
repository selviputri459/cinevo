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
    background-color: #dc35a4;
}

.film-card .text-muted {
    color: #d9a9bf !important;
}

@media (max-width: 1200px) {
    .carousel-control-prev {
        left: 10px;
    }

    .carousel-control-next {
        right: 10px;
    }
}

.how-to-book{
    margin-top: 48px;
    padding: 40px 24px 44px;
    border-radius: 18px;
    background: radial-gradient(circle at 50% -10%, #962161 0%, #4d0f2f 60%);
    color: #FBEFF4;
    text-align: center;
}
.how-title{
    font-weight: 600;
    margin: 0 0 6px;
}
.how-subtitle{
    color: #D79BB8;
    margin: 0 0 32px;
}
.how-steps{
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    max-width: 1000px;
    margin: 0 auto;
}
.how-step{
    position: relative;
    background: #4F1236;
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 16px;
    padding: 36px 18px 24px;
}
.how-number{
    position: absolute;
    top: -16px;
    left: 50%;
    transform: translateX(-50%);
    width: 34px;
    height: 34px;
    line-height: 34px;
    border-radius: 50%;
    background: #F2A6C6;
    color: #3B0A28;
    font-weight: 700;
}
.how-icon{
    font-size: 2rem;
    margin-bottom: 10px;
}
.how-step h3{
    font-size: 1.05rem;
    font-weight: 600;
    margin: 0 0 8px;
}
.how-step p{
    font-size: .88rem;
    color: #D79BB8;
    margin: 0;
    line-height: 1.5;
}

@media (max-width: 992px){
    .how-steps{ grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 480px){
    .how-steps{ grid-template-columns: 1fr; gap: 28px; }
}
</style>

<div class="container">

    {{-- banner / carousel --}}
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
                <h5>Temukan Ceritamu</h5>
                <p>Film favoritmu, siap menemani waktumu..</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('img/poster2.jpg') }}" class="d-block w-100" alt="Poster 2">
            <div class="carousel-caption d-none d-md-block">
                <h5>Waktunya Nonton</h5>
                <p>Pilih film, tentukan jadwal, dan nikmati ceritanya.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('img/poster3.jpeg') }}" class="d-block w-100" alt="Poster 3">
            <div class="carousel-caption d-none d-md-block">
                <h5>Segera Hadir</h5>
                <p>Bersiap untuk cerita baru di Cinevo.</p>
            </div>
        </div>
    </div>
    {{-- tombol kiri --}}
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    {{-- tombol kanan --}}
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

    {{-- sedang tayang --}}
    <h4 id="sedang-tayang" class="fw-bold mb-3">Sedang Tayang</h4>
    <div class="row g-3 mb-5">
        @forelse ($sedangTayang as $film)
            <div class="col-6 col-md-3">
                <div class="card h-100 shadow-sm film-card">
                    <img src="{{ $film->poster ? asset('storage/'.$film->poster) : 'https://placehold.co/300x400?text=Poster' }}"
                        class="card-img-top" alt="{{ $film->title }}" style="height:360px; object-fit:cover;">
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
            <p class="cinevo-muted">Belum ada film yang sedang tayang.</p>
        @endforelse
    </div>

    {{-- segera tayang --}}
    <h4 id="segera-tayang" class="fw-bold mb-3">Segera Tayang</h4>
    <div class="row g-3 mb-5">
        @forelse ($segeraTayang as $film)
            <div class="col-6 col-md-3">
                <div class="card h-100 shadow-sm film-card">
                    <img src="{{ $film->poster ? asset('storage/'.$film->poster) : 'https://placehold.co/300x400?text=Poster' }}"
                        class="card-img-top" alt="{{ $film->title }}" style="height:360px; object-fit:cover;">
                    <div class="card-body p-2">
                        <p class="mb-1 small fw-semibold">{{ $film->title }}</p>
                        <p class="mb-2 small text-muted">{{ $film->genre }} · {{ $film->duration }} menit</p>
                        <a href="{{ route('film.show', $film->id) }}" class="btn btn-outline-danger btn-sm w-100">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="cinevo-muted">Belum ada film yang akan segera tayang.</p>
        @endforelse
    </div>

    {{-- tutorial booking --}}
    <section class="how-to-book">
        <h2 class="how-title">Cara Booking Tiket</h2>
        <p class="how-subtitle">Pesan tiket bioskop cuma dalam 4 langkah</p>

        <div class="how-steps">
            <div class="how-step">
                <div class="how-number">1</div>
                <div class="how-icon">🎬</div>
                <h3>Pilih Film &amp; Jadwal</h3>
                <p>Pilih film yang ingin ditonton, lalu tentukan tanggal, jam, dan studionya.</p>
            </div>

            <div class="how-step">
                <div class="how-number">2</div>
                <div class="how-icon">💺</div>
                <h3>Pilih Kursi</h3>
                <p>Klik kursi yang masih tersedia. Kamu bisa memilih lebih dari satu kursi.</p>
            </div>

            <div class="how-step">
                <div class="how-number">3</div>
                <div class="how-icon">📝</div>
                <h3>Cek &amp; Konfirmasi</h3>
                <p>Periksa lagi detail pesananmu dan isi no. telepon, dan pilih metode pembayaran lalu konfirmasi booking. </p>
            </div>

            <div class="how-step">
                <div class="how-number">4</div>
                <div class="how-icon">🎟️</div>
                <h3>Pantau di Riwayat</h3>
                <p>Lihat status dan detail tiketmu kapan saja di menu Riwayat Booking.</p>
            </div>
        </div>
    </section>

</div>
@endsection