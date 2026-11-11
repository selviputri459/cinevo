@extends('layouts.user')

@section('title', 'E-Tiket ' . $booking->booking_code)

@push('styles')
<style>
    .ticket-wrap{ padding: 32px 16px 48px; }

    .eticket{
        max-width: 420px;
        margin: 0 auto;
        background: #fff;
        color: #2a0f1c;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 14px 40px rgba(0,0,0,.35);
        font-family: 'Inter', sans-serif;
    }
    .eticket-head{
        background: linear-gradient(90deg, #77254e, #58072d);
        color: #fff;
        padding: 18px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .eticket-head .brand{ font-weight: 700; font-size: 1.3rem; letter-spacing: .5px; }
    .eticket-head .tag{
        font-size: .72rem;
        padding: 3px 10px;
        border-radius: 999px;
        background: rgba(255,255,255,.2);
    }

    .eticket-body{ padding: 22px 24px; }
    .eticket-film{ font-size: 1.35rem; font-weight: 700; margin: 0 0 16px; }

    .eticket-grid{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px 18px;
        margin: 0;
    }
    .eticket-grid .full{ grid-column: 1 / -1; }
    .eticket-grid dt{
        font-size: .68rem;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #8a5a70;
        margin: 0;
    }
    .eticket-grid dd{ margin: 2px 0 0; font-weight: 600; }

    .eticket-tear{
        border-top: 2px dashed #d9b8c8;
        margin: 0 24px;
    }

    .eticket-code{
        text-align: center;
        padding: 18px 24px 24px;
    }
    .eticket-code small{ color: #8a5a70; }
    .eticket-code .code{
        font-size: 1.7rem;
        font-weight: 800;
        letter-spacing: .12em;
        color: #58072d;
        margin: 4px 0 8px;
    }
    .eticket-code .hint{ font-size: .78rem; color: #6b4a5a; }

    .eticket-invalid{
        background: #ffe3e3;
        color: #a61e1e;
        padding: 12px 24px;
        font-size: .85rem;
        text-align: center;
    }

    .ticket-actions{
        max-width: 420px;
        margin: 18px auto 0;
        display: flex;
        gap: 10px;
    }
    .ticket-actions a, .ticket-actions button{
        flex: 1;
        padding: 11px;
        border-radius: 9px;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-back{ background: transparent; border: 1px solid rgba(255,255,255,.4); color: #fff; }
</style>
@endpush

@section('content')
<div class="ticket-wrap">
    <div class="eticket">
        <div class="eticket-head">
            <span class="brand">Cinevo</span>
            <span class="tag">E-TIKET &bull; {{ strtoupper($booking->status) }}</span>
        </div>

        @if ($booking->status !== 'Lunas')
            <div class="eticket-invalid">
                Tiket ini <strong>tidak berlaku</strong> (status: {{ $booking->status }}).
                Hubungi admin untuk informasi lebih lanjut.
            </div>
        @endif

        @if ($booking->status === 'Lunas')
            <div class="hint">Tunjukkan e-tiket ini ke resepsionis / kasir sebelum masuk studio.</div>
        @endif

        <div class="eticket-body">
            <h2 class="eticket-film">{{ $booking->showtime->film->title }}</h2>

            <dl class="eticket-grid">
                <div>
                    <dt>Studio</dt>
                    <dd>{{ $booking->showtime->studio->name }}</dd>
                </div>
                <div>
                    <dt>Jumlah Tiket</dt>
                    <dd>{{ $booking->ticket_quantity }} tiket</dd>
                </div>
                <div>
                    <dt>Tanggal</dt>
                    <dd>{{ \Carbon\Carbon::parse($booking->showtime->date)->translatedFormat('d M Y') }}</dd>
                </div>
                <div>
                    <dt>Jam</dt>
                    <dd>{{ \Carbon\Carbon::parse($booking->showtime->time)->format('H:i') }} WIB</dd>
                </div>
                <div class="full">
                    <dt>Kursi</dt>
                    <dd>{{ $booking->bookingDetails->pluck('seat.seat_name')->join(', ') }}</dd>
                </div>
                <div class="full">
                    <dt>Atas Nama</dt>
                    <dd>{{ $booking->user->name }}</dd>
                </div>
            </dl>
        </div>

        <div class="eticket-tear"></div>

        <div class="eticket-code">
            <small>Kode Booking</small>
            <div class="code">{{ $booking->booking_code }}</div>
            <div class="hint">Tunjukkan e-tiket ini ke resepsionis / kasir sebelum masuk studio.</div>
        </div>
    </div>

    <div class="ticket-actions">
        <a href="{{ route('booking.show', $booking) }}" class="btn-back">Kembali</a>
    </div>
</div>
@endsection