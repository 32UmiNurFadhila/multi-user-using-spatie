<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Menu;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => auth()->user()->id,
                'note' => $request->note
            ]);

            $total = 0;
            foreach ($data['repeater-group'] as $group) {
                $menu_id = $group['menu_id'];
                $menu = Menu::findOrFail($menu_id);

                OrderDetail::create([
                    'order_id' => $order->id,
                    'menu_id' => $menu->id,
                    'quantity' => $group['quantity'],
                ]);

                $total += $menu->price * $group['quantity'];
            }

            $order->update(['total' => $total]);
            DB::commit();
            return redirect()->route('pending.show', $order->id)->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Pesanan gagal dibuat! '.$th->getMessage());
        }
    }

    public function show(Order $order)
    {
        $orderDetails = OrderDetail::where('order_id', $order->id)->get();
        return view('customer.order.detail', compact('orderDetails', 'order'));
    }

    public function pay(PaymentRequest $request, Order $order)
    {
        DB::beginTransaction();
        try {
            if ($request->payment < $order->total) {
                return redirect()->back()->with('error', 'Nominal pembayaran tidak cukup!');
            } else {
                $change = $request->payment - $order->total;
                $order->update([
                    'payment' => $request->payment,
                    'change' => $change,
                    'status' => 'done'
                ]);

                // Kurangi stok setelah pembayaran selesai
                foreach ($order->orderDetails as $detail) {
                    $menu = Menu::find($detail->menu_id);
                    if ($menu) {
                        $menu->stock -= $detail->quantity;
                        $menu->save();
                    }
                }

                DB::commit();
                return redirect()->back()->with('success', 'Pesanan berhasil dibayar!');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Pesanan gagal dibayar! '.$th->getMessage());
        }
    }

    /**
     * Update order status and reduce stock if completed
     */
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
    
        if ($request->status == 'Selesai' || $request->status == 'done') {
            foreach ($order->orderDetails as $detail) {
                $menu = Menu::find($detail->menu_id);
                if ($menu) {
                    $menu->stock -= $detail->quantity;
                    $menu->save();
                }
            }
        }
    
        $order->status = $request->status;
        $order->save();
    
        return redirect()->back()->with('success', 'Status pesanan diperbarui.');
    }

    /**
     * Menampilkan laporan transaksi
     */
    public function report(Request $request)
    {
        $penjualan = OrderDetail::whereHas('order', function ($query) {
            $query->where('status', 'done');
        })->orderBy('created_at', 'asc')->get();

        $subtotal = $penjualan->sum(function ($item) {
            return $item->menu->price * $item->quantity;
        });

        return view('laporan.penjualan', compact('penjualan', 'subtotal'));
    }

    /**
     * Download laporan penjualan dalam bentuk PDF
     */
    public function downloadReport()
    {
        $penjualan = OrderDetail::whereHas('order', function ($query) {
            $query->where('status', 'done');
        })->orderBy('created_at', 'asc')->get();

        $subtotal = $penjualan->sum(function ($item) {
            return $item->menu->price * $item->quantity;
        });

        $pdf = Pdf::loadView('laporan.penjualan_pdf', compact('penjualan', 'subtotal'));

        return $pdf->download('laporan_penjualan.pdf');
    }
}
