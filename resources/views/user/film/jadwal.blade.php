@extends('layouts.user')

@section('title', 'Pilih Jadwal - ' . $film->title)

@section('content')
<div class="container">

    {{-- Info Film --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex gap-3 align-items-center">
            <img src="{{ $film->poster ? asset('storage/'.$film->poster) : 'https://placehold.co/100x140?text=Poster' }}"
                style="width:80px; height:110px; object-fit:cover;" class="rounded" alt="{{ $film->title }}">
            <div>
                <h5 class="fw-bold mb-1">{{ $film->title }}</h5>
                <p class="mb-0 text-muted">{{ $film->genre }} · {{ $film->duration }} menit</p>
            </div>
        </div>
    </div>

    {{-- Tab Tanggal --}}
    <div class="d-flex gap-2 mb-4 flex-wrap">
        @foreach ($dates as $date)
            <a href="{{ route('film.jadwal', ['film' => $film->id, 'date' => $date]) }}"
                class="btn {{ $date == $selectedDate ? 'btn-danger' : 'btn-outline-secondary' }}"
                style="{{ $date == $selectedDate ? 'background-color:#f6b8b8; border:none;' : '' }}">
                {{ \Carbon\Carbon::parse($date)->translatedFormat('D') }}<br>
                {{ \Carbon\Carbon::parse($date)->format('d') }}
            </a>
        @endforeach
    </div>

    {{-- Form pilih jam --}}
    <form action="" method="GET">
        @if ($showtimesByStudio->isEmpty())
            <p class="text-muted">Tidak ada jadwal tayang di tanggal ini.</p>
        @endif

        @foreach ($showtimesByStudio as $studioId => $showtimes)
            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <p class="fw-semibold mb-2">{{ $showtimes->first()->studio->name }}</p>
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach ($showtimes as $showtime)
                                <input type="radio" class="btn-check" name="showtime_id"
                                    id="showtime{{ $showtime->id }}" value="{{ $showtime->id }}" required>
                                <label class="btn btn-outline-secondary" for="showtime{{ $showtime->id }}">
                                    {{ \Carbon\Carbon::parse($showtime->time)->format('H:i') }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="fw-semibold">
                        Rp{{ number_format($showtimes->first()->price, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        @endforeach

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-danger px-4" style="background-color:#f75cb1; border:none;">
                Lanjut Pilih Kursi
            </button>
        </div>
    </form>

</div>
@endsection