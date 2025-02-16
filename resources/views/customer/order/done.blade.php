@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-bold mb-4">Daftar Pesanan yang telah dikonfirmasi</h5>

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
                    @forelse ($doneOrders as $doneOrder)
                        <tr>
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ Carbon\Carbon::parse($doneOrder->created_at)->translatedFormat('d F Y') }}</td>
                            <td>{{ $doneOrder->user->name }}</td>
                            <td>{{ $doneOrder->user->email }}</td>
                            <td>Rp. {{ number_format($doneOrder->total, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('history.show', $doneOrder) }}" class="btn btn-primary">Detail</a>
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
