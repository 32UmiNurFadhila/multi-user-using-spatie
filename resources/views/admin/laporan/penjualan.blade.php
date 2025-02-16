@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-bold mb-4">Laporan Penjualan</h5>

        <form action="{{ route('admin.laporan.show') }}" method="GET">
            <div class="row">
                <div class="col-md-3">
                    <label for="start_date">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-2">
                    <label for="month">Pilih Bulan</label>
                    <select name="month" id="month" class="form-control">
                        <option value="">Pilih Bulan</option>
                        @foreach(range(1, 12) as $i)
                            <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="year">Pilih Tahun</label>
                    <select name="year" id="year" class="form-control">
                        <option value="">Pilih Tahun</option>
                        @foreach(range(date('Y'), 2020) as $i)
                            <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-sm me-2">Filter</button>
                    <a href="{{ route('admin.laporan.download', request()->all()) }}" class="btn btn-danger btn-sm">
                        <i class="fa fa-print"></i> Cetak
                    </a>
                </div>
            </div>
        </form>

        <h6 class="mt-3">Laporan Bulan: <strong>{{ request('month') ? date('F', mktime(0, 0, 0, request('month'), 1)) : 'Semua Bulan' }} {{ request('year') ?? '' }}</strong></h6>

        <table class="table caption-top mt-3">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Pesan</th>
                    <th>Nama Pelanggan</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Total</th>                   
                </tr>
            </thead>
            <tbody>
                @php
                    $subtotal = 0;
                @endphp
                @forelse ($penjualan as $data)
                    @php
                        $totalHarga = $data->menu->price * $data->quantity;
                        $subtotal += $totalHarga;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($data->order->created_at)->translatedFormat('d F Y') }}</td>
                        <td>{{ $data->order->user->name }}</td>
                        <td>{{ $data->menu->name }}</td>
                        <td>{{ $data->quantity }}</td>
                        <td>Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            <img src="{{ asset('assets/images/empty.png') }}" alt="Tidak ada data" width="200px">
                            <p class="fs-5 text-dark mt-2">Tidak ada data</p>
                        </td>
                    </tr>
                @endforelse
                @if ($subtotal > 0)
                    <tr>
                        <td colspan="5" class="text-end fw-bold">Subtotal</td>
                        <td class="fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection