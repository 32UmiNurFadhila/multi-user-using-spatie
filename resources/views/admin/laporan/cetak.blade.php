<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Laporan Penjualan</h2>
    <table>
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
            @php $subtotal = 0; @endphp
            @foreach ($penjualan as $data)
                @php
                    $totalHarga = $data->menu->price * $data->quantity;
                    $subtotal += $totalHarga;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->order->created_at)->format('d-m-Y') }}</td>
                    <td>{{ $data->order->user->name }}</td>
                    <td>{{ $data->menu->name }}</td>
                    <td>{{ $data->quantity }}</td>
                    <td>Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" class="text-end fw-bold">Subtotal</td>
                <td class="fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
