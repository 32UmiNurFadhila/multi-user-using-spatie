@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Produk dalam Kategori: {{ $category->name }}</h1>

        @if ($menus->isEmpty())
            <p>Tidak ada produk dalam kategori ini.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menus as $menu)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $menu->name }}</td>
                            <td>Rp{{ number_format($menu->price, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
@endsection
