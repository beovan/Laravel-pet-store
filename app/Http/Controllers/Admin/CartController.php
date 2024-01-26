<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\OrderItem;
use  App\Http\Services\CartService;
use App\Models\Order;

class CartController extends Controller
{


    public $cart;
    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
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
        $order = Order::where('customer_id', $customer->id)->first();
        $orderItems = OrderItem::whereHas('order', function ($query) use ($customer) {
            $query->where('customer_id', $customer->id);
        })->get();

        return view('admin.carts.detail', [
            'title' => 'Chi Tiết Đơn Hàng: ' . $customer->name,
            'customer' => $customer,
            'orderItems' => $orderItems,
            'order' => $order, // Pass the order to the view
        ]);
    }
}
