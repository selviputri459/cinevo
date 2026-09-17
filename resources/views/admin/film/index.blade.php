@extends('layouts.admin')

@section('title', 'Kelola Film')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Film</h1>
        <a href="{{ route('admin.film.create') }}" class="btn btn-danger">
            <i class="fas fa-plus fa-sm"></i> Tambah Film
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th style="width: 100px;">Poster</th>
                            <th>Judul</th>
                            <th>Genre</th>
                            <th>Durasi</th>
                            <th>Sinopsis</th>
                            <th style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($films as $film)
                            <tr>
                                <td>{{ $films->firstItem() + $loop->index }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $film->poster) }}" alt="{{ $film->title }}"
                                        style="width: 60px; height: 90px; object-fit: cover;" class="rounded">
                                </td>
                                <td>{{ $film->title }}</td>
                                <td>{{ $film->genre }}</td>
                                <td>{{ $film->duration }} menit</td>
                                <td>{{ Str::limit($film->synopsis, 80) }}</td>
                                <td>
                                    <a href="{{ route('admin.film.show', $film) }}" class="btn btn-info btn-sm"
                                        title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.film.edit', $film) }}" class="btn btn-warning btn-sm"
                                        title="Ubah">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.film.destroy', $film) }}" method="POST"
                                        class="d-inline form-delete-film">
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
                                <td colspan="7" class="text-center">Belum ada data film.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $films->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.form-delete-film').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus film ini?',
                    text: 'Data yang sudah dihapus tidak bisa dikembalikan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#e74a3b',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false,
            });
        @endif
    </script>
@endpush