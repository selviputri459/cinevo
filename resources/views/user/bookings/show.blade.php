@extends('layouts.user')

@section('title', 'Detail Booking')

@push('styles')
<style>
    .detail-page{
        background: radial-gradient(circle at 50% -10%, #7A1B4F 0%, #35081F 60%);
        color: #FBEFF4;
        border-radius: 18px;
        padding: 32px 24px 40px;
        font-family: 'Inter', sans-serif;
    }
    .detail-page h1{ font-weight:600; margin-bottom: 24px; }
    .detail-card{
        background: #4F1236;
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 16px;
        padding: 24px;
        max-width: 420px;
        margin: 0 auto;
    }
    .detail-card img{
        width: 100%;
        max-width: 160px;
        border-radius: 10px;
        display:block;
        margin: 0 auto 16px;
        object-fit: cover;
    }
    .detail-card dl{ margin:0; }
    .detail-card dt{
        font-size:.75rem;
        text-transform: uppercase;
        letter-spacing:.05em;
        color:#D79BB8;
        margin-top: 14px;
    }
    .detail-card dt:first-of-type{ margin-top:0; }
    .detail-card dd{ margin: 2px 0 0; font-weight:600; }

    .status-pill{
        display:inline-block;
        padding: 3px 12px;
        border-radius: 999px;
        font-size:.8rem;
        font-weight:600;
    }
    .status-pill.menunggu{ background: rgba(242,166,198,.18); color:#F2A6C6; }
    .status-pill.lunas{ background: rgba(120,220,150,.18); color:#7EDD9C; }
    .status-pill.batal{ background: rgba(255,255,255,.12); color:#D79BB8; }

    .btn-batalkan{
        width:100%;
        margin-top: 22px;
        padding: 11px;
        border-radius: 9px;
        border: none;
        background: rgba(242,166,198,.85);
        color: #3B0A28;
        font-weight:600;
        cursor:pointer;
    }
    .btn-batalkan:hover{ opacity:.9; }

    .alert-box{
        max-width: 420px;
        margin: 0 auto 16px;
        padding: 10px 14px;
        border-radius: 8px;
        font-size:.88rem;
    }
    .alert-success{ background: rgba(120,220,150,.18); color:#B7F0C7; }
    .alert-error{ background: rgba(255,120,120,.18); color:#FFC2C2; }
</style>
@endpush

@section('content')
<div class="detail-page">
    <h1>Detail Booking</h1>

    @if (session('success'))
        <div class="alert-box alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert-box alert-error">{{ $errors->first() }}</div>
    @endif

    <div class="detail-card">
        <img src="{{ $booking->showtime->film->poster ? asset('storage/'.$booking->showtime->film->poster) : 'https://placehold.co/160x220?text=Poster' }}"
            alt="{{ $booking->showtime->film->title }}">

        <dl>
            <dt>Judul Film</dt>
            <dd>{{ $booking->showtime->film->title }}</dd>

            <dt>Kode Booking</dt>
            <dd>{{ $booking->booking_code }}</dd>

            <dt>Studio</dt>
            <dd>{{ $booking->showtime->studio->name }}</dd>

            <dt>Tanggal - Jam</dt>
            <dd>
                {{ \Carbon\Carbon::parse($booking->showtime->date)->translatedFormat('d M Y') }},
                {{ \Carbon\Carbon::parse($booking->showtime->time)->format('H:i') }}
            </dd>

            <dt>Kursi</dt>
            <dd>{{ $booking->bookingDetails->pluck('seat.seat_name')->join(', ') }}</dd>

            <dt>Jumlah Tiket</dt>
            <dd>{{ $booking->ticket_quantity }} tiket</dd>

            <dt>Total</dt>
            <dd>Rp{{ number_format($booking->total_price, 0, ',', '.') }}</dd>

            <dt>Status</dt>
            <dd>
                @php
                    $statusClass = match($booking->status) {
                        'Lunas' => 'lunas',
                        'Dibatalkan' => 'batal',
                        default => 'menunggu',
                    };
                @endphp
                <span class="status-pill {{ $statusClass }}">{{ $booking->status }}</span>
            </dd>
        </dl>

        @if ($booking->status === 'Menunggu Bayar')
            <form action="{{ route('booking.cancel', $booking) }}" method="POST"
                onsubmit="return confirm('Yakin mau batalkan booking ini?');">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-batalkan">Batalkan Booking</button>
            </form>
        @endif
    </div>
</div>
@endsection