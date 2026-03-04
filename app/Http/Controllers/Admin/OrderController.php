<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items', 'user')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $term = $request->get('search');
            $query->where('customer_name', 'LIKE', "%{$term}%")
                  ->orWhere('phone', 'LIKE', "%{$term}%")
                  ->orWhere('id', $term);
        }

        $orders = $query->paginate(20);
        return view('admin.orders', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.food', 'user');
        return view('admin.order_show', compact('order'));
    }
}
