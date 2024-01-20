<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    public function index()
    {
        return view('admin.users.register',
            [
                'title' => 'Trang đăng kí',
            ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['level'] = 1; // Set the 'level' field to 1 for regular users
        
        $user = User::create($validatedData);
        Auth::login($user);
        Alert::success('Success', 'Đăng kí Thành công');
        return redirect('/');
    }
}
