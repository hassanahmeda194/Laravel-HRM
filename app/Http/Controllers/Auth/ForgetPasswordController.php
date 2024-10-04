<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgetPasswordController extends Controller
{
    public function forgetPassoword()
    {
        return view('Auth.forget-password');
    }
    public function SubmitForgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email'
        ]);
    }
}
