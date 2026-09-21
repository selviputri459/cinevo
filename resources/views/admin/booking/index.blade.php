@extends('layouts.admin')

@section('title', 'Kelola Data Booking')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Data Booking</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Kode Booking</th>
                            <th>Nama</th>
                            <th>Film</th>
                            <th>Jadwal</th>
                            <th>Jumlah Tiket</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th style="width: 90px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr>
                                <td>{{ $bookings->firstItem() + $loop->index }}</td>
                                <td>{{ $booking->booking_code }}</td>
                                <td>{{ $booking->user->name }}</td>
                                <td>{{ $booking->film->title }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($booking->showtime->date)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($booking->showtime->time)->format('H:i') }}
                                </td>
                                <td>{{ $booking->ticket_quantity }}</td>
                                <td>Rp{{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                <td>
                                    @php
                                        $badge = match ($booking->status) {
                                            'Lunas' => 'success',
                                            'Dibatalkan' => 'danger',
                                            default => 'warning',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badge }}">{{ $booking->status }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.booking.show', $booking) }}" class="btn btn-info btn-sm"
                                        title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Belum ada data booking.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
@endsection