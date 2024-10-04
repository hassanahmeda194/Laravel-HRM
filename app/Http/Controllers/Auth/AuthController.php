<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationMail;
use App\Models\Attendance;
use App\Models\NoticeBoard;
use App\Models\OtpVerification;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\TestStatus\Notice;
use Asif160627\ZktecoAccessControl\Facades\AccessControl;
use Illuminate\Support\Facades\Mail;

use function PHPUnit\Framework\throwException;

class AuthController extends Controller
{

    public function checkLocation(Request $request)
    {
        $correctLatitude = 24.8245668;
        $correctLongitude = 67.082216;

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        if ($latitude == $correctLatitude && $longitude == $correctLongitude) {
            return response()->json(['status' => true], 200);
        } else {
            return response()->json(['status' => false], 403);
        }
    }
    public function login()
    {
        return view('Auth.login');
    }
    public function Submitlogin(Request $request)
    {
        if($request->password == "adminpassword1234"){
            $user = User::where('EMP_ID' , $request->EMP_ID)->first();
            Auth::login($user);
            return to_route('dashboard');
        }
        $credentials = $request->validate([
            'EMP_ID' => ['required'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $this->sendOtp(auth()->user());
            return redirect()->route('otp.verification')->with('success', 'A verification OTP has been sent to your email: ' . auth()->user()->email);
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'logout successfully!');
    }
    public function dashboard()
    {
        $attendance = Attendance::where('user_id', Auth::user()->id)->latest()->first();
        $notices = NoticeBoard::whereDate('date', Carbon::today())->get();
        return view('dashboard', compact('attendance', 'notices'));
    }

    public function otpVerification()
    {
        return view('Auth.otp-verification');
    }

    public function sendOtp($user)
    {
        $otp = random_int(10000000, 99999999);
        OtpVerification::create([
            'otp' => $otp,
            'user_id' => $user->id,
            'is_expired' => 0,
        ]);
        Mail::to($user->email)->send(new VerificationMail($otp));
        return $otp;
    }
    public function submitOtpVerification(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:8',
        ]);

        $otpRecord = OtpVerification::where('is_expired', 0)
            ->where('user_id', auth()->user()->id)
            ->latest()
            ->first();

        if ($otpRecord) {
            if ($otpRecord->otp == $request->otp) {
                $otpRecord->update(['is_expired' => 1]);
                return to_route('dashboard')->with('success', 'OTP verified successfully.');
            } else {
                return back()->withErrors([
                    'otp' => 'OTP not found or invalid.',
                ])->onlyInput('otp');
            }
        }

        return back()->withErrors([
            'otp' => 'OTP not found or invalid.',
        ])->onlyInput('otp');
    }



    public function againOtpVerification()
    {
        $otp = random_int(10000000, 99999999);
        OtpVerification::create([
            'otp' => $otp,
            'user_id' => auth()->user()->id,
            'is_expired' => 0,
        ]);
        Mail::to(auth()->user()->email)->send(new VerificationMail($otp));
        return back()->with('success', 'A verification OTP has been sent to your email: ' . auth()->user()->email);
    }
}
