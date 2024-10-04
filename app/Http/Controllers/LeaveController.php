<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Leave;
use App\Models\LeaveQuota;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaveController extends Controller
{

    public function index()
    {
        $users = User::all(['id', 'name']);
        $leaves = Leave::with('user')->get();
        return view('Leave.index', compact('users', 'leaves'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'leave_type' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $leaveQuota = LeaveQuota::where('user_id', $request->user_id)->first();
            if (!$leaveQuota) {
                return back()->with('error', 'Leave quota not found for the user!');
            }
            $attendances = [];
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
            $numberOfDays = $endDate->diffInDays($startDate) + 1;
            if ($leaveQuota->{$request->leave_type} < $numberOfDays) {
                return back()->with('error', 'Marked leave exceeds available quota!');
            }
            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                switch ($request->leave_type) {
                    case 'sick_leave':
                        $leaveQuota->sick_leave--;
                        break;
                    case 'annual_leave':
                        $leaveQuota->annual_leave--;
                        break;
                    case 'casual_leave':
                        $leaveQuota->casual_leave--;
                        break;
                    default:
                        $leaveQuota->unpaid_leave++;
                        break;
                }
                if ($request->leave_type === "sick_leave") {
                    $status = 7;
                } elseif ($request->leave_type == "casual_leave") {
                    $status = 8;
                } elseif ($request->leave_type == "annual_leave") {
                    $status = 9;
                } elseif ($request->leave_type == "unpaid_leave") {
                    $status = 6;
                }
                $attendances[] = [
                    'user_id' => $request->user_id,
                    'check_in' => null,
                    'check_out' => null,
                    'status' => $status,
                    'created_at' => $date->toDateTimeString(),
                ];

                Leave::create([
                    'date' => $date,
                    'user_id' => $request->user_id,
                    'reason' => $request->reason,
                    'leave_type' => $status,
                    'reason' => $request->reason
                ]);
            }
            Attendance::insert($attendances);
            $leaveQuota->save();
            DB::commit();
            return back()->with('success', 'Leave applied successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return back()->with('error', 'Leave applied Failed!');
        }
    }

    public function destroy($id)
    {
        try {
            $leave = Leave::find($id);
            $leaveQuota = LeaveQuota::where('user_id', $leave->user_id)->first();
            if ($leave->leave_type == 6) {
                $leaveQuota->unpaid_leave -= 1;
            } elseif ($leave->leave_type == 7) {
                $leaveQuota->sick_leave += 1;
            } elseif ($leave->annaul_leave == 8) {
                $leaveQuota->casual_leave += 1;
            } elseif ($leave->annaul_leave == 9) {
                $leaveQuota->annual_leave += 1;
            }
            $leaveQuota->save();
            $leave->delete();
            return back()->with('success', 'leave deteled successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', 'leave deteled failed!');
        }
    }
}
