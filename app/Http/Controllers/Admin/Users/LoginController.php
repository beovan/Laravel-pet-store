<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


//use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view(
            'admin.users.login',
            ['title' => 'Đăng nhập hệ thống']
        );
    }

    public function logout()
    {
        // Log out the user
        auth()->logout();

        // Clear the user-related session data
        Session::forget('users'); // Replace 'key' with the key of the session data you want to remove

        // Redirect to the desired page
        return redirect('/');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email:filter',
            'password' => 'required'
        ]);
        
        $credentials = $request->only('email', 'password');
        
        if (!Auth::attempt($credentials, $request->input('remember'))) {
            session()->flash('error', 'email hoặc mật khẩu không chính xác');
            return redirect()->back();
        }
        
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            session()->flash('error', 'Email không tồn tại.');
            return redirect()->back();
        }
        
        if (!Hash::check($request->password, $user->password)) {
            session()->flash('error', 'Mật khẩu không chính xác.');
            return redirect()->back();
        }
        
        Auth::login($user);
        
        if ($user->isAdmin()) {
            return redirect()->route('admin');
        }
        
        $user->level = 1;
        Alert::success('Success Title', 'Đăng nhập Thành công');
        return redirect('/');
    }
}
