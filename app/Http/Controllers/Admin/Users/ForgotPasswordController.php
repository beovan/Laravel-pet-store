<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view(
            'admin.users.email',
            ['title' => 'reset password']
        );
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
        // dd($request->only('email'));
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );
       

        return $response == Password::RESET_LINK_SENT
            ? back()->with('status', trans($response))
            : back()->withErrors(['email' => trans($response)]);
    }

    protected function broker()
    {
        return Password::broker();
    }
}
