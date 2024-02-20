<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User as User;
use App\Models\Product;
use Carbon\Carbon;

class MainController extends Controller
{
    public function index()
    {
        $users = User::all();
        $orders = Order::all();
        $sevenDaysAgo = Carbon::now()->subDays(7);
        $recentOrders = $orders->where('created_at', '>=', $sevenDaysAgo);
        $products = Product::all();
        echo view('admin.home', [
            'title' => 'Trang Quản trị Admin',
            "orders" => $recentOrders,
            "users" => $users,
            "products" => $products
        ]);
    }
    function getSalesData()
    {
        // get data from database
        $data = Order::all();

        return response()->json($data);
    }
}
