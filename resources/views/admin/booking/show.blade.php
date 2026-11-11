@extends('layouts.admin')

@section('title', 'Detail Booking')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Booking</h1>
        <a href="{{ route('admin.booking.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left fa-sm"></i> Kembali
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

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
                            <th style="width: 180px;">Nama Customer</th>
                            <td>: {{ $booking->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>: {{ $booking->user->email }}</td>
                        </tr>
                        <tr>
                            <th>No. Telepon</th>
                            <td>: {{ $booking->user->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Judul Film</th>
                            <td>: {{ $booking->film->title }}</td>
                        </tr>
                        <tr>
                            <th>Kode Booking</th>
                            <td>: {{ $booking->booking_code }}</td>
                        </tr>
                        <tr>
                            <th>Studio</th>
                            <td>: {{ $booking->showtime->studio->name }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal - Jam</th>
                            <td>:
                                {{ \Carbon\Carbon::parse($booking->showtime->date)->format('d-m-Y') }}
                                {{ \Carbon\Carbon::parse($booking->showtime->time)->format('H:i') }} WIB
                            </td>
                        </tr>
                        <tr>
                            <th>Kursi</th>
                            <td>: {{ $booking->bookingDetails->pluck('seat.seat_name')->implode(', ') }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Tiket</th>
                            <td>: {{ $booking->ticket_quantity }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>: Rp{{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        </tr>

                        {{-- BARU: info pembayaran --}}
                        <tr>
                            <th>Metode Pembayaran</th>
                            <td>:
                                @if ($booking->isTransfer())
                                    Transfer ({{ $booking->payment_channel }})
                                @else
                                    Bayar di Kasir
                                @endif
                            </td>
                        </tr>

                        @if ($booking->isTransfer())
                            <tr>
                                <th>Rekening Pengirim</th>
                                <td>: {{ $booking->sender_account }}</td>
                            </tr>
                            <tr>
                                <th>Bukti Transfer</th>
                                <td>
                                    @if ($booking->payment_proof)
                                        <a href="{{ asset('storage/' . $booking->payment_proof) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $booking->payment_proof) }}"
                                                alt="Bukti transfer" class="img-thumbnail"
                                                style="max-height: 260px;">
                                        </a>
                                        <div class="small text-muted mt-1">Klik gambar untuk memperbesar.</div>
                                    @else
                                        : -
                                    @endif
                                </td>
                            </tr>
                        @endif

                        <tr>
                            <th>Status</th>
                            <td>:
                                @php
                                    $badge = match ($booking->status) {
                                        'Lunas' => 'success',
                                        'Dibatalkan' => 'danger',
                                        'Menunggu Verifikasi' => 'info',
                                        default => 'warning',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badge }} badge-{{ $badge }}">{{ $booking->status }}</span>
                            </td>
                        </tr>

                        @if ($booking->refund_status)
                            <tr>
                                <th>Status Refund</th>
                                <td>:
                                    <span class="badge {{ $booking->refund_status === 'Sudah Direfund' ? 'bg-success badge-success' : 'bg-warning badge-warning' }}">
                                        {{ $booking->refund_status }}
                                    </span>
                                    <span class="small text-muted">
                                        (Rp{{ number_format($booking->total_price, 0, ',', '.') }}
                                        ke {{ $booking->payment_channel }} {{ $booking->sender_account }})
                                    </span>
                                </td>
                            </tr>
                        @endif
                    </table>

                    <div class="mt-3">
                        @if (in_array($booking->status, ['Menunggu Bayar', 'Menunggu Verifikasi']))
                            <form action="{{ route('admin.booking.lunas', $booking) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check"></i>
                                    {{ $booking->status === 'Menunggu Verifikasi' ? 'Verifikasi & Lunas' : 'Lunas' }}
                                </button>
                            </form>
                        @endif

                        @if ($booking->status !== 'Dibatalkan')
                            <form action="{{ route('admin.booking.cancel', $booking) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('{{ $booking->isTransfer() ? 'Booking transfer: uang customer harus dikembalikan (refund). Lanjut batalkan?' : 'Yakin ingin membatalkan booking ini?' }}');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-times"></i> Batalkan Booking
                                </button>
                            </form>
                        @endif

                        @if ($booking->refund_status === 'Menunggu Refund')
                            <form action="{{ route('admin.booking.refund', $booking) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Pastikan uang sudah dikirim ke customer. Tandai sudah direfund?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-undo"></i> Tandai Sudah Direfund
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection