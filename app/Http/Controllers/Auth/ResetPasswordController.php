<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request)
    {
        return view('Auth.reset-password');
    }
    public function SubmitResetPassword(Request $request)
    {
        
    }
}
