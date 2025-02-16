<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Laporan Penjualan</h2>
    <h4>Laporan Bulan: <strong>{{ request('month') ? \Carbon\Carbon::createFromFormat('m', request('month'))->translatedFormat('F') : 'Semua Bulan' }} {{ request('year') ?? '' }}</strong></h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
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
            @foreach($penjualan as $key => $item)
                @php
                    $total = $item->menu->price * $item->quantity;
                    $subtotal += $total;
                @endphp
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                    <td>{{ $item->order->user->name }}</td>
                    <td>{{ $item->menu->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" style="text-align: right; font-weight: bold;">Subtotal</td>
                <td style="font-weight: bold;">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
