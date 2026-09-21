@extends('layouts.admin')

@section('title', 'Detail Booking')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Booking</h1>
        <a href="{{ route('admin.booking.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left fa-sm"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <img src="{{ asset('storage/' . $booking->film->poster) }}" alt="{{ $booking->film->title }}"
                        class="img-fluid rounded">
                </div>
                <div class="col-md-9">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 180px;">Judul Film</th>
                            <td>: {{ $booking->film->title }}</td>
                        </tr>
                        <tr>
                            <th>Kode Booking</th>
                            <td>: {{ $booking->booking_code }}</td>
                        </tr>
                        <tr>
                            <th>User</th>
                            <td>: {{ $booking->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Studio</th>
                            <td>: {{ $booking->showtime->studio->name }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal - Jam</th>
                            <td>:
                                {{ \Carbon\Carbon::parse($booking->showtime->date)->format('d-m-Y') }} -
                                {{ \Carbon\Carbon::parse($booking->showtime->time)->format('H:i') }} WIB
                            </td>
                        </tr>
                        <tr>
                            <th>Kursi</th>
                            <td>:
                                {{ $booking->bookingDetails->pluck('seat.seat_name')->implode(', ') }}
                            </td>
                        </tr>
                        <tr>
                            <th>Jumlah Tiket</th>
                            <td>: {{ $booking->ticket_quantity }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>: Rp{{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>:
                                @php
                                    $badge = match ($booking->status) {
                                        'Lunas' => 'success',
                                        'Dibatalkan' => 'danger',
                                        default => 'warning',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ $booking->status }}</span>
                            </td>
                        </tr>
                    </table>

                    <div class="mt-3">
                        @if ($booking->status === 'Menunggu Bayar')
                            <form action="{{ route('admin.booking.lunas', $booking) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check"></i> Lunas
                                </button>
                            </form>
                        @endif

                        @if ($booking->status !== 'Dibatalkan')
                            <form action="{{ route('admin.booking.cancel', $booking) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin membatalkan booking ini?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-times"></i> Batalkan Booking
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection