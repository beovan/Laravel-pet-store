<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\OrderItem;
use  App\Http\Services\CartService;
use App\Http\Services\Order\OrderService;
use App\Models\Order;
use Illuminate\Http\Request;

class CartController extends Controller
{


    public $cart;
    public $order;
    public function __construct(CartService $cart,OrderService $order)
    {
        $this->cart = $cart;
        $this->order = $order;
    }

    public function index()
    {
        return view('admin.carts.customer', [
            'title' => 'Danh Sách Đơn Đặt Hàng',
            'customers' => $this->cart->getCustomer()
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

        return view('admin.carts.detail', [
            'title' => 'Chi Tiết Đơn Hàng: ' . $customer->name,
            'customer' => $customer,
            'orderItems' => $orderItems,
            'order' => $order, // Pass the order to the view
        ]);
    }
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validatedData = $request->validate([
            'status' => 'required|in:cancelled,processing,delivered,pending',
        ]);

        $order->status = $validatedData['status'];
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }
}
