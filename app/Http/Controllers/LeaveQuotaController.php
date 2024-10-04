<?php

namespace App\Http\Controllers;

use App\Models\LeaveQuota;
use Illuminate\Http\Request;

class LeaveQuotaController extends Controller
{
    public function index()
    {
        $leave_quota = LeaveQuota::with('user')->get();
        return view('Leave.leaveQuota', compact('leave_quota'));
    }
}
