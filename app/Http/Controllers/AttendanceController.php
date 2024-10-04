<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date ? Carbon::parse($request->date) : Carbon::now();
        $startDateTimeToday = $date->copy()->setTime(7, 0);
        $endDateTimeToday = $startDateTimeToday->copy()->addDay();
        $attendanceRecords = Attendance::with('user')
            ->whereBetween('created_at', [$startDateTimeToday, $endDateTimeToday])
            ->get();
        if ($attendanceRecords->isEmpty()) {
            $startDateTimeYesterday = $startDateTimeToday->copy()->subDay();
            $endDateTimeYesterday = $endDateTimeToday->copy()->subDay();
            $attendanceRecords = Attendance::with('user')
                ->whereBetween('created_at', [$startDateTimeYesterday, $endDateTimeYesterday])
                ->get();
        }
        if (in_array(Auth::user()->designation_id, [1, 2])) {
            $attendances = $attendanceRecords;
        } else {
            $attendances = Attendance::with('user')
                ->whereMonth('created_at', $date->month)
                ->where('user_id', Auth::user()->id)
                ->get();
        }
        return view('Attendance.index', compact('attendances'));
    }


    public function show(Request $request)
    {
        $attendance = Attendance::find($request->id);
        return view('partials.modals.attendance-modal', compact('attendance'))->render();
    }

    public function update(Request $request, Attendance $attendance)
    {
        $attendance = Attendance::where('user_id', $request->user_id)
            ->where('created_at', $request->created_at)
            ->first();

        $status = $request->mark_full_day ? 1 : 4;
        if ($attendance) {
            $attendance->update([
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'status' => $status
            ]);
        } else {
            Attendance::create([
                'user_id' => $request->user_id,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'status' => $status
            ]);
        }
        return back()->with('success', 'Attendance marked Successfully');
    }
}
