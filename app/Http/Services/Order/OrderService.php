<?php

namespace App\Http\Services\Order;

use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request; // Add the missing import statement for the Request class

class OrderService
{
    public function show()
    {
        return Order::select(
            'order_number',
            'customer_id',
            'total_amount',
            'status',
        )
        ->orderbyDesc('id')
        ->get();
    }
    public function getOrderById($orderId)
    {
        try {
            $order = Order::with('customer', 'orderItems')->findOrFail($orderId);
            return $order;
        } catch (\Exception $err) {
            Log::info($err->getMessage());
            return null;
        }
    }

    public function updateOrderStatus(Request $request, $orderId) // Add the Request parameter to the method signature
    {
        $status = $request->input('status');
        // ...
        $this->updateOrderStatus($orderId, $status);

        return redirect()->back();
    }
}
