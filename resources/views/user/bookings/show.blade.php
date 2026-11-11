@extends('layouts.user')

@section('title', 'Detail Booking')

@push('styles')
<style>
    .detail-page{
        background: radial-gradient(circle at 50% -10%, #7A1B4F 0%, #35081F 60%);
        color: #FBEFF4;
        border-radius: 18px;
        padding: 40px 24px 48px;
        font-family: 'Inter', sans-serif;
    }

    .detail-header{
        text-align: center;
        margin-bottom: 28px;
    }
    .detail-header h1{
        font-weight: 600;
        margin: 0 0 8px;
    }
    .code-chip{
        display: inline-block;
        padding: 4px 14px;
        border-radius: 999px;
        background: rgba(255,255,255,.1);
        border: 1px solid rgba(255,255,255,.15);
        font-size: .85rem;
        letter-spacing: .04em;
        color: #F2A6C6;
    }

    .detail-card{
        background: #4F1236;
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 16px;
        padding: 32px;
        max-width: 900px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 36px;
    }
    .detail-poster img{
        width: 100%;
        aspect-ratio: 2 / 3;
        object-fit: cover;
        border-radius: 12px;
        display: block;
        box-shadow: 0 10px 28px rgba(0,0,0,.35);
    }

    .detail-info{
        display: flex;
        flex-direction: column;
    }
    .detail-film-title{
        font-size: 1.6rem;
        font-weight: 600;
        margin: 0 0 20px;
        line-height: 1.25;
    }
    .detail-grid{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px 24px;
        margin: 0;
    }
    .detail-grid .full{ grid-column: 1 / -1; }
    .detail-grid dt{
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: #D79BB8;
        margin: 0;
    }
    .detail-grid dd{
        margin: 3px 0 0;
        font-weight: 600;
        font-size: 1.02rem;
    }
    .detail-total{
        padding-top: 18px;
        border-top: 1px dashed rgba(255,255,255,.2);
    }
    .detail-total dd{
        font-size: 1.5rem;
        color: #F2A6C6;
    }

    .status-pill{
        display: inline-block;
        padding: 3px 12px;
        border-radius: 999px;
        font-size: .8rem;
        font-weight: 600;
    }
    .status-pill.menunggu{ background: rgba(242,166,198,.18); color:#F2A6C6; }
    .status-pill.lunas{ background: rgba(120,220,150,.18); color:#7EDD9C; }
    .status-pill.batal{ background: rgba(255,255,255,.12); color:#D79BB8; }

    .detail-actions{
        margin-top: auto;
        padding-top: 24px;
        display: flex;
        justify-content: flex-end;
    }
    .btn-batalkan{
        min-width: 220px;
        padding: 12px 20px;
        border-radius: 9px;
        border: none;
        background: rgba(242,166,198,.85);
        color: #3B0A28;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-batalkan:hover{ opacity:.9; }

    .alert-box{
        max-width: 900px;
        margin: 0 auto 16px;
        padding: 10px 14px;
        border-radius: 8px;
        font-size: .88rem;
    }
    .alert-success{ background: rgba(120,220,150,.18); color:#B7F0C7; }
    .alert-error{ background: rgba(255,120,120,.18); color:#FFC2C2; }

    @media (max-width: 768px){
        .detail-card{
            grid-template-columns: 1fr;
            padding: 24px 20px;
            gap: 24px;
        }
        .detail-poster img{
            max-width: 200px;
            margin: 0 auto;
        }
        .detail-film-title{ text-align: center; }
        .btn-batalkan{ width: 100%; }
    }
    @media (max-width: 480px){
        .detail-grid{ grid-template-columns: 1fr; }
    }

        .proof-thumb{
        max-width: 140px;
        border-radius: 8px;
        border: 1px solid rgba(255,255,255,.2);
        display: block;
        margin-top: 6px;
    }
    .detail-note{
        margin-top: 18px;
        padding: 10px 14px;
        border-radius: 8px;
        font-size: .88rem;
        background: rgba(255,255,255,.08);
        color: #FBEFF4;
    }
    .detail-page a.btn-ticket{
    display: inline-block;
    min-width: 220px;
    padding: 12px 20px;
    border-radius: 9px;
    background: #F2A6C6;
    color: #3B0A28 !important;
    font-weight: 600;
    text-align: center;
    text-decoration: none;
    }
    .detail-page a.btn-ticket:hover{
        opacity: .9;
        color: #3B0A28 !important;
    }
</style>
@endpush

@section('content')
<div class="detail-page">
    <div class="detail-header">
        <h1>Detail Booking</h1>
        <span class="code-chip">{{ $booking->booking_code }}</span>
    </div>

    @if (session('success'))
        <div class="alert-box alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert-box alert-error">{{ $errors->first() }}</div>
    @endif

    <div class="detail-card">
        <div class="detail-poster">
            <img src="{{ $booking->showtime->film->poster ? asset('storage/'.$booking->showtime->film->poster) : 'https://placehold.co/240x360?text=Poster' }}"
                alt="{{ $booking->showtime->film->title }}">
        </div>
        <div class="detail-info">
            <h2 class="detail-film-title">{{ $booking->showtime->film->title }}</h2>

            <dl class="detail-grid">
                <div>
                    <dt>Studio</dt>
                    <dd>{{ $booking->showtime->studio->name }}</dd>
                </div>

                <div>
                    <dt>Tanggal - Jam</dt>
                    <dd>
                        {{ \Carbon\Carbon::parse($booking->showtime->date)->translatedFormat('d M Y') }},
                        {{ \Carbon\Carbon::parse($booking->showtime->time)->format('H:i') }}
                    </dd>
                </div>

                <div>
                    <dt>Kursi</dt>
                    <dd>{{ $booking->bookingDetails->pluck('seat.seat_name')->join(', ') }}</dd>
                </div>

                <div>
                    <dt>Jumlah Tiket</dt>
                    <dd>{{ $booking->ticket_quantity }} tiket</dd>
                </div>

                <div>
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
                </div>

                <div>
                    <dt>Pembayaran</dt>
                    <dd>{{ $booking->isTransfer() ? 'Transfer ('.$booking->payment_channel.')' : 'Bayar di Kasir' }}</dd>
                </div>

                @if ($booking->isTransfer() && $booking->payment_proof)
                    <div>
                        <dt>Bukti Transfer</dt>
                        <dd>
                            <a href="{{ asset('storage/'.$booking->payment_proof) }}" target="_blank">
                                <img src="{{ asset('storage/'.$booking->payment_proof) }}" alt="Bukti transfer" class="proof-thumb">
                            </a>
                        </dd>
                    </div>
                @endif

                <div class="full detail-total">
                    <dt>Total Pembayaran</dt>
                    <dd>Rp{{ number_format($booking->total_price, 0, ',', '.') }}</dd>
                </div>
            </dl>

            @if ($booking->status === 'Menunggu Bayar')
                <div class="detail-actions">
                    <form action="{{ route('booking.cancel', $booking) }}" method="POST"
                        onsubmit="return confirm('Yakin mau batalkan booking ini?');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-batalkan">Batalkan Booking</button>
                    </form>
                </div>
            @endif

            @if ($booking->status === 'Menunggu Verifikasi')
                <div class="detail-note">
                    Bukti transfer kamu sedang diverifikasi admin. E-tiket akan tersedia setelah pembayaran dinyatakan lunas.
                </div>
            @endif

            @if ($booking->isTransfer() && $booking->status === 'Lunas')
                <div class="detail-actions">
                    <a href="{{ route('booking.ticket', $booking) }}" class="btn-ticket">Lihat E-Tiket</a>
                </div>
                <div class="detail-note">
                    Booking transfer tidak bisa dibatalkan sendiri. Hubungi admin lewat WhatsApp jika ada kendala.
                </div>
            @endif

            @if ($booking->refund_status === 'Menunggu Refund')
                <div class="detail-note">
                    Booking dibatalkan. Uang kamu (Rp{{ number_format($booking->total_price, 0, ',', '.') }}) akan dikembalikan ke
                    {{ $booking->payment_channel }} {{ $booking->sender_account }}.
                </div>
            @elseif ($booking->refund_status === 'Sudah Direfund')
                <div class="detail-note">
                    Refund Rp{{ number_format($booking->total_price, 0, ',', '.') }} sudah dikirim ke
                    {{ $booking->payment_channel }} {{ $booking->sender_account }}.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection