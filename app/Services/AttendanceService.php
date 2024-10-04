<?php

namespace App\Services;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceService
{

    public function CheckIn()
    {
        try {
            $user = Auth::user();
            $today = Carbon::today();
            $status = $this->checkInStatusCalculation($user);
            $attendance = Attendance::where('user_id', $user->id)
                ->whereDate('created_at', $today)
                ->first();
            if ($attendance) {
                $attendance->update([
                    'check_in' => now(),
                    'status' => $status
                ]);
            } else {
                $yesterday = Carbon::yesterday();
                $lastAttendance = Attendance::where('user_id', $user->id)
                    ->whereDate('created_at', $yesterday)
                    ->first();
                if ($lastAttendance) {
                    $lastAttendance->update([
                        'check_in' => now(),
                        'status' => $status
                    ]);
                } else {
                    Attendance::create([
                        'user_id' => $user->id,
                        'check_in' => now(),
                        'check_out' => null,
                        'status' => $status
                    ]);
                }
            }

            return back()->with('success', 'Attendance marked successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to mark attendance!');
        }
    }

    public function CheckOut()
    {
        try {
            $attendance = Attendance::where('user_id', Auth::user()->id)->latest()->first();
            $status = $this->checkOutStatusCalculation($attendance);
            $attendance->update([
                'check_out' => now(),
                'status' => $status
            ]);

            return back()->with('success', 'Attendance mark successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Attendance not  mark !');
        }
    }

    public function checkInStatusCalculation($user)
    {
        $graceTimingMinutes = 15;
        $shiftStartTime = Carbon::parse($user->employement_info->shift_start_time);
        $currentTime = Carbon::now();

        if ($user->employement_info->flexible_timing == 1) {
            return 1;
        } else {
            $shiftStartWithGrace = $shiftStartTime->copy()->addMinutes($graceTimingMinutes);
            if ($currentTime >= $shiftStartWithGrace) {
                return 3;
            } else {
                return 1;
            }
        }
    }


    public function checkOutStatusCalculation($attendance)
    {
        $checkIn = Carbon::parse($attendance->check_in);
        $checkOut = Carbon::now();
        $totalHoursWorked = $checkIn->diffInHours($checkOut);

        if ($totalHoursWorked < 4) {
            return 6; 
        } elseif ($totalHoursWorked >= 4 && $totalHoursWorked < 7) {
            return 4; 
        } elseif ($totalHoursWorked >= 7 && $totalHoursWorked < 9) {
            return 3; 
        } else {
            return $attendance->status;
        }
    }
}
