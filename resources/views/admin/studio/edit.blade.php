@extends('layouts.admin')

@section('title', 'Ubah Studio')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Studio</h1>
        <a href="{{ route('admin.studio.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.studio.update', $studio) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ old('name', $studio->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="capacity">Capacity</label>
                    <input type="number" name="capacity" id="capacity" class="form-control"
                        value="{{ old('capacity', $studio->capacity) }}" required>
                </div>

                <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection