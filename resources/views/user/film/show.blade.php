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
            <a href="{{ route('film.jadwal', $film->id) }}" class="btn btn-danger mt-3"
                style="background-color:#f75cb1; border:none;">
                Pilih Jadwal Tayang
            </a>
        </div>
    </div>
 </div>

</div>
@endsection