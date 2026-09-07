@extends('layouts.user')

@section('title', 'Riwayat Booking')

@push('styles')
<style>
    .riwayat-page{
        background: radial-gradient(circle at 50% -10%, #7A1B4F 0%, #35081F 60%);
        color: #FBEFF4;
        border-radius: 18px;
        padding: 32px 24px 40px;
        font-family: 'Inter', sans-serif;
    }
    .riwayat-page h1{ font-weight:600; margin-bottom: 20px; }

    .riwayat-tabs{
        display:flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 26px;
    }
    .riwayat-tabs a{
        padding: 7px 18px;
        border-radius: 999px;
        border: 1px solid rgba(255,255,255,.18);
        color: #D79BB8;
        text-decoration:none;
        font-size:.88rem;
        font-weight:500;
    }
    .riwayat-tabs a.active{
        background: #F2A6C6;
        border-color: #F2A6C6;
        color: #3B0A28;
        font-weight:600;
    }

    .riwayat-list{ display:flex; flex-direction:column; gap: 14px; max-width: 640px; }
    .riwayat-card{
        display:flex;
        gap: 16px;
        align-items:center;
        background: #4F1236;
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 14px;
        padding: 16px;
        text-decoration:none;
        color: #FBEFF4;
    }
    .riwayat-card:hover{ background: #5C1541; }
    .riwayat-card img{
        width: 64px;
        height: 88px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink:0;
    }
    .riwayat-card .info{ flex:1; min-width:0; }
    .riwayat-card .info h3{ font-size:1rem; font-weight:600; margin: 0 0 4px; }
    .riwayat-card .info p{ margin: 0; font-size:.82rem; color:#D79BB8; }
    .riwayat-card .side{ text-align:right; flex-shrink:0; }
    .riwayat-card .side .total{ font-weight:600; margin-bottom: 6px; }

    .status-pill{
        display:inline-block;
        padding: 3px 12px;
        border-radius: 999px;
        font-size:.75rem;
        font-weight:600;
    }
    .status-pill.menunggu{ background: rgba(242,166,198,.18); color:#F2A6C6; }
    .status-pill.lunas{ background: rgba(120,220,150,.18); color:#7EDD9C; }
    .status-pill.batal{ background: rgba(255,255,255,.12); color:#D79BB8; }

    .riwayat-empty{ color:#D79BB8; text-align:center; padding: 40px 0; }
</style>
@endpush

@section('content')
<div class="riwayat-page">
    <h1>Riwayat Booking</h1>

    <div class="riwayat-tabs">
        <a href="{{ route('booking.index', ['status' => 'semua']) }}" class="{{ $status === 'semua' ? 'active' : '' }}">Semua</a>
        <a href="{{ route('booking.index', ['status' => 'selesai']) }}" class="{{ $status === 'selesai' ? 'active' : '' }}">Selesai</a>
        <a href="{{ route('booking.index', ['status' => 'menunggu']) }}" class="{{ $status === 'menunggu' ? 'active' : '' }}">Menunggu</a>
        <a href="{{ route('booking.index', ['status' => 'dibatalkan']) }}" class="{{ $status === 'dibatalkan' ? 'active' : '' }}">Dibatalkan</a>
    </div>

    @if ($bookings->isEmpty())
        <p class="riwayat-empty">Belum ada booking di kategori ini.</p>
    @else
        <div class="riwayat-list">
            @foreach ($bookings as $booking)
                @php
                    $statusClass = match($booking->status) {
                        'Lunas' => 'lunas',
                        'Dibatalkan' => 'batal',
                        default => 'menunggu',
                    };
                @endphp
                <a href="{{ route('booking.show', $booking) }}" class="riwayat-card">
                    <img src="{{ $booking->showtime->film->poster ? asset('storage/'.$booking->showtime->film->poster) : 'https://placehold.co/64x88?text=Poster' }}"
                        alt="{{ $booking->showtime->film->title }}">

                    <div class="info">
                        <h3>{{ $booking->showtime->film->title }}</h3>
                        <p>{{ $booking->showtime->studio->name }}</p>
                        <p>
                            {{ \Carbon\Carbon::parse($booking->showtime->date)->translatedFormat('d M Y') }},
                            {{ \Carbon\Carbon::parse($booking->showtime->time)->format('H:i') }}
                        </p>
                        <p>{{ $booking->ticket_quantity }} tiket</p>
                    </div>

                    <div class="side">
                        <div class="total">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</div>
                        <span class="status-pill {{ $statusClass }}">{{ $booking->status }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection