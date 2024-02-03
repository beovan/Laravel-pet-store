<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\OrderItem;
use App\Http\Services\Order\OrderService;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{


    public $order;
    public function __construct(OrderService $order)
    {
        $this->order = $order;
    }

    public function index()
    {
        $customers = $this->order->getCustomer();
        return view('admin.orders.list', [
            'title' => 'Danh Sách Đơn Đặt Hàng',
            'customers' => $customers,
        ]);
    }

    public function show(Customer $customer)
    {
        // $carts = $this->cart->getProductForCart($customer);
        // $order = Order::where('customer_id', $customer->id)->first();
        $order = $this->order->getOrderByCustomerId($customer->id);
        $orderItems = OrderItem::whereHas('order', function ($query) use ($customer) {
            $query->where('customer_id', $customer->id);
        })->paginate(3);
        return view('admin.orders.detail', [
            'title' => 'Chi Tiết Đơn Hàng: ' . $customer->name,
            'customer' => $customer,
            'orderItems' => $orderItems,
            'order' => $order, // Pass the order to the view
        ]);
    }
    public function update(Request $request, $id)
    {
        $status = $request->input('status');

        // Validate the status
        if (!in_array($status, ['cancelled', 'processing', 'delivered'])) {
            return redirect()->back()->with('error', 'Invalid status.');
        }

        // Use the OrderService to update the order status
        $orderService = new OrderService(); // Assuming OrderService is in the same namespace
        $updateStatus = $orderService->updateOrderStatus($request, $id);

        if ($updateStatus) {
            return redirect()->back()->with('success', 'Trạng thái đơn hàng được cập nhật thành công!');
        } else {
            return redirect()->back()->with('error', 'Không cập nhật được trạng thái đơn hàng!');
        }
    }
}
