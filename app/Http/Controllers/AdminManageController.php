<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminManageController extends Controller
{
    public function pending()
    {
        $pendingOrders = Order::where('status', 'pending')->get();

        return view('customer.order.pending', compact('pendingOrders'));
    }

    public function done()
    {
        $doneOrders = Order::where('status', 'done')->get();

        return view('customer.order.done', compact('doneOrders'));
    }
}
