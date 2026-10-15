@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

    <!-- Kartu Statistik -->
    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Film
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalFilm }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-film fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Jadwal
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalJadwal }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Studio
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStudio }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-door-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Booking
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBooking }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-ticket-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Booking Terbaru -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-wrap align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Booking Terbaru</h6>
            <div>
                <a href="{{ url()->current() }}?filter=semua"
                    class="btn btn-sm {{ $filter === 'semua' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Semua
                </a>
                <a href="{{ url()->current() }}?filter=baru"
                    class="btn btn-sm {{ $filter === 'baru' ? 'btn-danger' : 'btn-outline-danger' }}">
                    Baru <span class="badge badge-light">{{ $totalBaru }}</span>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            @forelse ($bookingTerbaru as $booking)
                <div class="d-flex align-items-center p-3 {{ !$loop->last ? 'border-bottom' : '' }} {{ $booking->is_new ? 'booking-baru' : '' }}">
                    <img src="{{ $booking->showtime->film->poster ? asset('storage/' . $booking->showtime->film->poster) : asset('img/no-image.png') }}"
                         alt="{{ $booking->showtime->film->title }}"
                         class="rounded"
                         style="width: 60px; height: 80px; object-fit: cover;">

                    <div class="ml-3">
                        <div class="font-weight-bold">
                            {{ $booking->showtime->film->title }}
                            @if ($booking->is_new)
                                <span class="badge badge-baru ml-2">BARU</span>
                            @endif
                        </div>
                        <div class="text-muted small">
                            {{ $booking->showtime->studio->name }} -
                            {{ \Carbon\Carbon::parse($booking->showtime->date)->translatedFormat('d M Y') }}
                        </div>
                    </div>

                    <div class="ml-auto font-weight-bold">
                        Rp{{ number_format($booking->total_price, 0, ',', '.') }}
                    </div>
                </div>
            @empty
                <p class="text-muted mb-0 p-3">
                    {{ $filter === 'baru' ? 'Tidak ada booking baru.' : 'Belum ada booking.' }}
                </p>
            @endforelse
        </div>
    </div>

@endsection

@push('styles')
<style>
    .booking-baru {
        background: #fdecef;
        border-left: 4px solid #e74a3b;
    }
    .booking-baru .badge-baru {
        background: #e74a3b;
        color: #fff;
    }
</style>
@endpush