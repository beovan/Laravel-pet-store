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
         return Order::with('customer', 'orderItems')
        ->select(
            'order_number',
            'customer_id',
            'total_amount',
            'status',
        )
        ->orderbyDesc('id')
        ->get();
    }
    public function getOrderByCustomerId($customerId)
{
    try {
        $order = Order::where('customer_id', $customerId
        )->with('customer', 'orderItems')
        ->first();
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
    public function get()
    {
    
        return Order::orderByDesc('id')->paginate(3);
    }
}
