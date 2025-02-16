@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Data Kategori</h1>

        <!-- Tombol Tambah Kategori -->
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">Tambah Kategori</a>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <!-- Nama kategori dibuat sebagai link ke daftar barang -->
                        <td>
                            <a href="{{ route('admin.categories.show', $category->id) }}" class="text-primary">
                                {{ $category->name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
