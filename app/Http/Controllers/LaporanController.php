<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function laporanPenjualan(Request $request)
    {
        // Ambil data penjualan berdasarkan filter yang dipilih
        $penjualan = OrderDetail::with(['order.user', 'menu'])
            ->when($request->start_date, fn($q) => 
                $q->whereHas('order', fn($o) => $o->whereDate('created_at', '>=', $request->start_date)))
            ->when($request->end_date, fn($q) => 
                $q->whereHas('order', fn($o) => $o->whereDate('created_at', '<=', $request->end_date)))
            ->when($request->month, fn($q) => 
                $q->whereHas('order', fn($o) => $o->whereMonth('created_at', $request->month)))
            ->when($request->year, fn($q) => 
                $q->whereHas('order', fn($o) => $o->whereYear('created_at', $request->year)))
            ->orderBy('created_at', 'asc') // Pastikan data diurutkan dengan benar
            ->get();

        // Hitung subtotal penjualan
        $subtotal = $penjualan->sum(fn($data) => $data->menu->price * $data->quantity);

        // Load view laporan dan kirimkan data penjualan + subtotal
        $pdf = Pdf::loadView('laporan.penjualan', compact('penjualan', 'subtotal'));

        // Kembalikan sebagai response agar tampil dalam modal
        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="laporan_penjualan.pdf"');
    }

    public function done(Request $request)
    {
        // Ambil data penjualan berdasarkan filter yang dipilih
        $penjualan = OrderDetail::with(['order.user', 'menu'])
            ->when($request->start_date, fn($q) => 
                $q->whereHas('order', fn($o) => $o->whereDate('created_at', '>=', $request->start_date)))
            ->when($request->end_date, fn($q) => 
                $q->whereHas('order', fn($o) => $o->whereDate('created_at', '<=', $request->end_date)))
            ->when($request->month, fn($q) => 
                $q->whereHas('order', fn($o) => $o->whereMonth('created_at', $request->month)))
            ->when($request->year, fn($q) => 
                $q->whereHas('order', fn($o) => $o->whereYear('created_at', $request->year)))
            ->orderBy('created_at', 'asc') // Pastikan data diurutkan dengan benar
            ->get();
            // dd($penjualan);
        // Hitung subtotal penjualan
        $subtotal = $penjualan->sum(fn($data) => $data->menu->price * $data->quantity);

        // Tampilkan halaman laporan dengan data yang difilter
        return view('admin.laporan.penjualan', compact('penjualan', 'subtotal') + 
            $request->only(['start_date', 'end_date', 'month', 'year']));
    }
}
