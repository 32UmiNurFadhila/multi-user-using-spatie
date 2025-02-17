@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Data Kategori</h1>

        {{-- Tampilkan pesan error jika ada --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

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

                            @if ($category->products()->count() > 0)
                                <!-- Jika kategori digunakan di produk, tombol hapus dinonaktifkan -->
                                <button class="btn btn-danger btn-sm" disabled data-bs-toggle="tooltip" title="Kategori ini sedang digunakan dan tidak bisa dihapus">
                                    Hapus
                                </button>
                            @else
                                <!-- Jika kategori tidak memiliki produk, tombol hapus bisa digunakan -->
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Tambahkan script untuk tooltip Bootstrap -->
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
@endsection
