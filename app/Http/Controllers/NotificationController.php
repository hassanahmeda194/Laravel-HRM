<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function getNotification()
    {
        $notifications = Auth::user()->notifications;
        return view('partials.notification', compact('notifications'))->render();
    }

    public function readNotification(Request $request)
    {
        try {
            DB::table('notifications')->where('id', $request->id)->update([
                'read_at' => now()
            ]);
            return response()->json(true);
        } catch (\Throwable $th) {
            return response()->json(false);
        }
    }

    
}
