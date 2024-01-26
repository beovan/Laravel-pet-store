<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use  App\Http\Services\CartService;
use App\Http\Services\Order\OrderService;

class UserProfileController extends Controller
{
    // Show the user profile

    protected $cartService;
    protected $orderService;
    public function __construct(OrderService $orderService,CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }
    public function show()
    {
        $user = auth()->user(); // Get the authenticated user
        $products = $this->cartService->getProduct();
        // Retrieve the user's order history
        $orders = $this->orderService->show();
        $customers = Customer::all(); // Retrieve all customers
        return view('profile.show', [
            'title' => 'User Profile',
            'user' => $user,
            'user_id' => $user->id,
            'orders' => $orders,
            'customers' => $customers,
            'products' => $products
        ]);
    }






// Update the user profile
    public function update(Request $request)
    {
        $user = User::findOrFail($request->id);
        $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'sometimes|nullable|string|min:8|confirmed',
    ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        // You can update other profile fields here as needed

        $user->update();
        return redirect()->route('profile.show')->with('success', 'Profile updated successfully');
    }


}
