@extends('layouts.admin')

@section('title', 'Kelola Jadwal Tayang')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Jadwal Tayang</h1>
        <a href="{{ route('admin.showtime.create') }}" class="btn btn-danger">
            <i class="fas fa-plus fa-sm"></i> Tambah Jadwal Tayang
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">

            {{-- ===== 1. FORM FILTER (paling atas) ===== --}}
            <form method="GET" action="{{ url()->current() }}" class="mb-4">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="row">
                    {{-- Search menyeluruh --}}
                    <div class="col-md-12 mb-2">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Cari judul film atau nama studio..."
                                value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Filter film --}}
                    <div class="col-md-3 mb-2">
                        <select name="film_id" class="form-control">
                            <option value="">Semua Film</option>
                            @foreach ($films as $film)
                                <option value="{{ $film->id }}" {{ request('film_id') == $film->id ? 'selected' : '' }}>
                                    {{ $film->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter studio --}}
                    <div class="col-md-3 mb-2">
                        <select name="studio_id" class="form-control">
                            <option value="">Semua Studio</option>
                            @foreach ($studios as $studio)
                                <option value="{{ $studio->id }}" {{ request('studio_id') == $studio->id ? 'selected' : '' }}>
                                    {{ $studio->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter tanggal --}}
                    <div class="col-md-2 mb-2">
                        <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                    </div>

                    {{-- Filter jam dari - sampai --}}
                    <div class="col-md-2 mb-2">
                        <input type="time" name="time_from" class="form-control"
                            value="{{ request('time_from') }}" title="Jam mulai dari">
                    </div>
                    <div class="col-md-2 mb-2">
                        <input type="time" name="time_to" class="form-control"
                            value="{{ request('time_to') }}" title="Sampai jam">
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-filter"></i> Terapkan Filter
                        </button>
                        <a href="{{ url()->current() }}?tab={{ $tab }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-undo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>

            {{-- ===== 2. TAB (pindah ke sini, tepat di atas tabel) ===== --}}
            <ul class="nav nav-tabs mb-0">
                <li class="nav-item">
                    <a class="nav-link {{ $tab === 'aktif' ? 'active' : '' }}"
                        href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->except('tab', 'page'), ['tab' => 'aktif'])) }}">
                        Jadwal Aktif <span class="badge badge-success">{{ $totalAktif }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab === 'riwayat' ? 'active' : '' }}"
                        href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->except('tab', 'page'), ['tab' => 'riwayat'])) }}">
                        Riwayat (Sudah Tayang) <span class="badge badge-secondary">{{ $totalRiwayat }}</span>
                    </a>
                </li>
            </ul>

            {{-- ===== 3. TABEL ===== --}}
            <div class="table-responsive">
                <table class="table table-bordered align-middle" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Film</th>
                            <th>Studio</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Harga</th>
                            <th style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($showtimes as $showtime)
                            <tr>
                                <td>{{ $showtimes->firstItem() + $loop->index }}</td>
                                <td>{{ $showtime->film->title }}</td>
                                <td>{{ $showtime->studio->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($showtime->date)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($showtime->time)->format('H:i') }}</td>
                                <td>Rp{{ number_format($showtime->price, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('admin.showtime.show', $showtime) }}" class="btn btn-info btn-sm"
                                        title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.showtime.edit', $showtime) }}" class="btn btn-warning btn-sm"
                                        title="Ubah">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.showtime.destroy', $showtime) }}" method="POST"
                                        class="d-inline form-delete-showtime">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    {{ $tab === 'riwayat' ? 'Belum ada riwayat jadwal tayang.' : 'Belum ada jadwal tayang aktif.' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $showtimes->links() }}
            </div>
        </div>
    </div>

<form action="" method="POST" id="form-destroy">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $('.datatable').DataTable();
    });

    function handleDestroy(url) {
        Swal.fire({
            title: "Apa kamu yakin?",
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-destroy').attr('action', url);
                $('#form-destroy').submit();
            }
        });
    }
</script>

@if(Session::has('success'))
<script>
    Swal.fire({
        title: "Berhasil!",
        text: "{{ Session::get('success') }}",
        icon: "success"
    });
</script>
@endif
@endpush