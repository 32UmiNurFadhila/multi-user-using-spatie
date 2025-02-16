@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title fw-bold mb-4">Detail Pesanan</h5>
                @if (auth()->user()->hasRole('admin') && $order->status == 'pending')
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-create">Bayar</button>
                @endif
            </div>
            <div id="order-summary">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Menu</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderDetails as $orderDetail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $orderDetail->menu->name }}</td>
                                <td>Rp. {{ number_format($orderDetail->menu->price, 0, ',', '.') }}</td>
                                <td>{{ $orderDetail->quantity }}</td>
                                <td>Rp. {{ number_format($orderDetail->menu->price * $orderDetail->quantity, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-between">
                    <strong>Total: Rp. {{ number_format($order->total, 0, ',', '.') }}</strong>
                </div>
            </div>
            @if ($order->note != null)
            <hr><br>
            <h6>Catatan: </h6>
            <p>{{ $order->note }}</p>
            @endif
            <hr><br>
            @if ($order->status == 'done')
                <h6>Nominal yang dibayarkan: Rp. {{ number_format($order->payment, 0, ',', '.') }}</h6>
                <h6>Kembalian: Rp. {{ number_format($order->change, 0, ',', '.') }}</h6>
            @endif
        </div>
    </div>

    @if (auth()->user()->hasRole('admin') && $order->status == 'pending')
    <div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="createMenu" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createMenu">Bayar Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.order.pay', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <h6 class="fw-semibold">Total yang harus dibayarkan: Rp.
                            {{ number_format($order->total, 0, ',', '.') }}</h6>
                        <div class="form-group mb-3">
                            <label for="payment">Nominal pembayaran (Rp.)</label>
                            <input type="number" class="form-control" name="payment" id="payment"
                                placeholder="Masukkan nominal pembayaran" value="{{ old('payment') }}">
                            @error('payment')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger"
                            data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-rounded btn-primary">Bayarkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

@endsection
