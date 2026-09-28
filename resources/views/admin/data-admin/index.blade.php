@extends('layouts.admin')

@section('title', 'Kelola Data Admin')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Data Admin</h1>
        <a href="{{ route('admin.data-admin.create') }}" class="btn btn-danger">
            <i class="fas fa-plus fa-sm"></i> Tambah Admin
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th style="width: 100px;">Profil</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($admins as $admin)
                            <tr>
                                <td>{{ $admins->firstItem() + $loop->index }}</td>
                                <td>
                                    <img src="{{ $admin->profile_photo ? asset('storage/' . $admin->profile_photo) : asset('img/undraw_profile.svg') }}"
                                        alt="{{ $admin->name }}" class="rounded-circle"
                                        style="width: 45px; height: 45px; object-fit: cover;">
                                </td>
                                <td>
                                    {{ $admin->name }}
                                    @if ($admin->id === auth('admin')->id())
                                        <span class="badge badge-info">Kamu</span>
                                    @endif
                                </td>
                                <td>{{ $admin->email }}</td>
                                <td>
                                    @if ($admin->id !== auth('admin')->id())
                                        <button type="button" class="btn btn-danger btn-sm" title="Hapus"
                                            onclick="handleDestroy('{{ route('admin.data-admin.destroy', $admin) }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data admin.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $admins->links() }}
            </div>
        </div>
    </div>

    {{-- Form tersembunyi: action-nya diisi lewat JavaScript saat tombol Hapus diklik --}}
    <form action="" method="POST" id="form-destroy">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
    <script>
        // Munculkan konfirmasi SweetAlert, kalau "Ya" baru form hapus dikirim
        function handleDestroy(url) {
            Swal.fire({
                title: "Apa kamu yakin?",
                text: "Data admin yang dihapus tidak dapat dikembalikan!",
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

    @if (Session::has('success'))
        <script>
            Swal.fire({ title: "Berhasil!", text: @json(Session::get('success')), icon: "success" });
        </script>
    @endif

    @if (Session::has('error'))
        <script>
            Swal.fire({ title: "Gagal!", text: @json(Session::get('error')), icon: "error" });
        </script>
    @endif
@endpush