@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-bold mb-4">Daftar Pesanan yang belum dikonfirmasi</h5>

        <table class="table caption-top">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal Pesan</th>
                    <th scope="col">Nama Pelanggan</th>
                    <th scope="col">Email</th>
                    <th scope="col">Total</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pendingOrders as $pendingOrder)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ Carbon\Carbon::parse($pendingOrder->created_at)->translatedFormat('d F Y') }}</td>
                        <td>{{ $pendingOrder->user->name }}</td>
                        <td>{{ $pendingOrder->user->email }}</td>
                        <td>Rp. {{ number_format($pendingOrder->total, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('pending.show', $pendingOrder) }}"
                                class="btn btn-primary">{{ auth()->user()->hasRole('customer') ? 'Detail' : 'Konfirmasi' }}</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <img src="{{ asset('assets/images/empty.png') }}" alt="" width="200px">
                                <p class="fs-5 text-dark text-center mt-2">
                                    Tidak ada data
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
