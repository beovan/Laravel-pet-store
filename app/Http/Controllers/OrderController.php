<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Import the Order model or adjust the namespace as needed
use App\Models\OrderItem; // Import the OrderItem model if you have one
class OrderController extends Controller
{

    public function index()
    {

        $orders = Order::all();
        return view('orders.index', [
            'title' => 'Đơn hàng',
            'orders' => $orders
        ]);
    }
    public function show($id)
    {

        $order = Order::find($id);
        $user = auth()->user();

        if (!$order) {
            abort(404);

            // Retrieve the order items associated with the order
            $orderItems = $order->items; // Assuming you have a relationship defined in your Order model
            $orders = Order::where('customer_id', $user->id)->orderByDesc('created_at')->get();
            return view('orders.show', [
                'title' => 'Chi tiết đơn hàng',
                'order' => $order,
                'orders' => $orders,
                'orderItems' => $orderItems
            ]);
        }
    }
}
