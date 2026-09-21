@extends('layouts.admin')

@section('title', 'Detail Studio')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Studio</h1>
        <a href="{{ route('admin.studio.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th style="width: 160px;">Name</th>
                            <td>: {{ $studio->name }}</td>
                        </tr>
                        <tr>
                            <th>Capacity</th>
                            <td>: {{ $studio->capacity }}</td>
                        </tr>
                    </table>

                    <div class="mt-4">
                        <a href="{{ route('admin.studio.edit', $studio) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Ubah
                        </a>
                        <form action="{{ route('admin.studio.destroy', $studio) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Hapus studio ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection