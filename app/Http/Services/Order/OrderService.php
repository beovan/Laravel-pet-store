<?php

namespace App\Http\Services\Order;

use App\Models\Customer;
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
            ->paginate(3);
    }
    public function getOrderByCustomerId($customerId)
    {
        try {
            $order = Order::where('customer_id', $customerId)
                ->with('customer', 'orderItems')
                ->first();

            Log::info('Order retrieved: ', ['order' => $order]);
            return $order;
        } catch (\Exception $err) {
            Log::info($err->getMessage());
            return null;
        }
    }

    public function updateOrderStatus(Request $request, $orderId)
    {
        // Validate the request data
        $request->validate([
            'status' => 'required|in:cancelled,processing,delivered',
        ]);

        // Find the order by its ID
        $order = Order::find($orderId);

        // Check if order exists
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        // Update the order status
        $order->status = $request->input('status');
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function getCustomer()
    {
        return Customer::orderByDesc('id')->paginate(5);
    }
}
