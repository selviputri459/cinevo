@extends('layouts.user')

@section('title', 'Booking Tiket')

@push('styles')
<style>
    .booking-page{
        background: radial-gradient(circle at 50% -10%, #7A1B4F 0%, #35081F 60%);
        color: #FBEFF4;
        border-radius: 18px;
        padding: 32px 24px 40px;
        font-family: 'Inter', sans-serif;
    }
    .booking-page h1{
        text-align:center;
        font-weight:600;
        margin-bottom: 28px;
    }
    .booking-layout{
        display:flex;
        gap: 28px;
        flex-wrap: wrap;
        justify-content:center;
        align-items:flex-start;
    }
    .booking-card{
        background: #4F1236;
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 16px;
        padding: 24px;
        width: 360px;
    }
    .booking-card img{
        width: 100%;
        max-width: 160px;
        border-radius: 10px;
        display:block;
        margin: 0 auto 16px;
        object-fit: cover;
    }
    .booking-card dl{ margin:0; }
    .booking-card dt{
        font-size:.75rem;
        text-transform: uppercase;
        letter-spacing:.05em;
        color:#D79BB8;
        margin-top: 14px;
    }
    .booking-card dt:first-of-type{ margin-top:0; }
    .booking-card dd{
        margin: 2px 0 0;
        font-weight:600;
    }
    .booking-form{
        background: #4F1236;
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 16px;
        padding: 24px;
        width: 360px;
    }
    .booking-form h3{
        font-size:1.05rem;
        font-weight:600;
        margin: 0 0 16px;
    }
    .booking-form label{
        display:block;
        font-size:.8rem;
        color:#D79BB8;
        margin-bottom: 4px;
    }
    .booking-form .field{ margin-bottom: 16px; }
    .booking-form input[readonly]{
        width:100%;
        padding: 9px 12px;
        border-radius: 8px;
        border: 1px solid rgba(255,255,255,.15);
        background: rgba(255,255,255,.06);
        color: #FBEFF4;
    }
    .btn-booking{
        width:100%;
        padding: 11px;
        border-radius: 9px;
        border: none;
        background: #F2A6C6;
        color: #3B0A28;
        font-weight:600;
        cursor:pointer;
        margin-top: 6px;
    }
    .btn-booking:hover{ opacity:.92; }
</style>
@endpush

@section('content')
<div class="booking-page">
    <h1>Booking Tiket</h1>

    <div class="booking-layout">
        <div class="booking-card">
            <img src="{{ $showtime->film->poster ? asset('storage/'.$showtime->film->poster) : 'https://placehold.co/160x220?text=Poster' }}"
                alt="{{ $showtime->film->title }}">

            <dl>
                <dt>Judul Film</dt>
                <dd>{{ $showtime->film->title }}</dd>

                <dt>Studio</dt>
                <dd>{{ $showtime->studio->name }}</dd>

                <dt>Tanggal - Jam</dt>
                <dd>
                    {{ \Carbon\Carbon::parse($showtime->date)->translatedFormat('d M Y') }},
                    {{ \Carbon\Carbon::parse($showtime->time)->format('H:i') }}
                </dd>

                <dt>Kursi</dt>
                <dd>{{ $seats->pluck('seat_name')->join(', ') }}</dd>

                <dt>Jumlah Tiket</dt>
                <dd>{{ $seats->count() }} tiket</dd>

                <dt>Total</dt>
                <dd>Rp{{ number_format($total, 0, ',', '.') }}</dd>
            </dl>
        </div>

        <form class="booking-form" action="{{ route('booking.store') }}" method="POST">
            @csrf
            <h3>Data Pemesanan</h3>

            <div class="field">
                <label>Nama</label>
                <input type="text" value="{{ auth()->user()->name }}" readonly>
            </div>

            <div class="field">
                <label>Email</label>
                <input type="text" value="{{ auth()->user()->email }}" readonly>
            </div>

            <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
            @foreach ($seats as $seat)
                <input type="hidden" name="seat_id[]" value="{{ $seat->id }}">
            @endforeach

            <button type="submit" class="btn-booking">Booking Tiket</button>
        </form>
    </div>
</div>
@endsection