<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CustomerManageController extends Controller
{
    public function pending()
    {
        if (auth()->user()->hasRole('customer')) {
            $pendingOrders = Order::where('user_id', auth()->user()->id)->where('status', 'pending')->get();
        } 

        return view('customer.order.pending', compact('pendingOrders'));
    }

    public function done()
    {
        if (auth()->user()->hasRole('customer')) {
            $doneOrders = Order::where('user_id', auth()->user()->id)->where('status', 'done')->get();
        } 

        return view('customer.order.done', compact('doneOrders'));
    }
}
