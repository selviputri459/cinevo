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
                                <td colspan="7" class="text-center">Belum ada jadwal tayang.</td>
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