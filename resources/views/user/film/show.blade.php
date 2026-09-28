@extends('layouts.user')

@section('title', $film->title)

@section('content')

<style>
    .cinevo-main {
        min-height: calc(100vh - 76px);
        padding-top: 0;
        padding-bottom: 0;
    }

    .film-detail {
        position: relative;
        min-height: calc(100vh - 76px);
        overflow: hidden;
        padding: 50px 0 80px;
    }

    .film-detail::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image: url('{{ asset('storage/' . $film->poster) }}');
        background-size: cover;
        background-position: center;
        filter: blur(6px);
        transform: scale(1.05);
        opacity: 0.5;
        z-index: 0;
    }

    .film-detail::after {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(53, 5, 26, 0.55);
        z-index: 1;
    }

    .film-detail-content {
        position: relative;
        z-index: 2;
    }

    .film-poster {
        width: 100%;
        max-width: 300px;
        height: 440px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
    }
</style>

<div class="film-detail">
    <div class="container film-detail-content">
        <div class="row align-items-start g-5">
            <div class="col-md-4 text-center">
                <img src="{{ asset('storage/' . $film->poster) }}"
                    class="film-poster"
                    alt="{{ $film->title }}">
            </div>

            <div class="col-md-8">
                <h1 class="fw-bold text-white">{{ $film->title }}</h1>

                <p class="cinevo-muted">
                    {{ $film->genre }} · {{ $film->duration }} menit
                </p>

                <p class="text-white">
                    {{ $film->synopsis }}
                </p>

                <a href="{{  route('film.jadwal', $film)  }}" class="btn cinevo-btn-primary">
                    Pilih Jadwal Tayang
                </a>
            </div>
        </div>
    </div>
</div>

@endsection