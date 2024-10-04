<?php

namespace App\Http\Controllers;

use App\Helpers\CustomHelper;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\LeaveQuota;
use App\Models\LeaveRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = LeaveRequest::with('user')->OrderByDesc('id')->where('user_id', Auth::user()->id)->get();
        return view('leave-request.index', compact('requests'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'leave_type' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'required'
        ]);
        try {
            $leaveQuota = LeaveQuota::find(Auth::user()->id);
            if ($request->leave_type != 'unpaid_leave' && $leaveQuota->{$request->leave_type} >= 0) {
                return back()->with('error', 'You do not have sufficient leave quota for this request');
            }
            LeaveRequest::create([
                'title' => $request->title,
                'description' => $request->description,
                'leave_type' => $request->leave_type,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'user_id' => Auth::user()->id,
            ]);
            $user = Auth::user();
            $users = User::whereIn('designation_id', [1, 2])->get();
            CustomHelper::SendNotification($users, 2, "$user->name has requested for leave.");
            return back()->with('success', 'leave request successfully submited!');
        } catch (\Throwable $th) {
            return back()->with('error', 'leave request submited Failed!');
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            $request = LeaveRequest::find($request->id);
            return view('partials.modals.edit-leave-request-modal', compact('request'))->render();
        } catch (\Exception $e) {
            return response()->json('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'leave_type' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'required'
        ]);
        try {
            $leaveQuota = LeaveQuota::find(Auth::user()->id);
            if ($request->leave_type != 'unpaid_leave' && $leaveQuota->{$request->leave_type} >= 0) {
                return back()->with('error', 'You do not have sufficient leave quota for this request');
            }
            LeaveRequest::find($id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'leave_type' => $request->leave_type,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'user_id' => Auth::user()->id,
            ]);

            $user = Auth::user();
            $users = User::whereIn('designation_id', [1, 2])->get();
            CustomHelper::SendNotification($users, 2, "$user->name Update a leave request.");

            return back()->with('success', 'leave request successfully Updated!');
        } catch (\Throwable $th) {
            return back()->with('error', 'leave request submited Updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            LeaveRequest::find($id)->delete();
            return back()->with('success', 'leave request successfully deleted!');
        } catch (\Throwable $th) {
            return back()->with('error', 'leave request deleted Failed!');
        }
    }

    public function getAllLeaveRequest()
    {
        $requests = LeaveRequest::all();
        return view('leave-request.all-request', compact('requests'));
    }

    public function leaveRequestApprove($id)
    {
        DB::beginTransaction();
        try {
            $LeaveRequest = LeaveRequest::find($id);
            $leaveQuota = LeaveQuota::where('user_id', $LeaveRequest->user_id)->first();
            if (!$leaveQuota) {
                return back()->with('error', 'Leave quota not found for the user!');
            }
            $attendances = [];
            $startDate = Carbon::parse($LeaveRequest->start_date);
            $endDate = Carbon::parse($LeaveRequest->end_date);
            $numberOfDays = $endDate->diffInDays($startDate) + 1;
            if ($LeaveRequest->leave_type != 'unpaid_leave' && $leaveQuota->{$LeaveRequest->leave_type} < $numberOfDays) {
                return back()->with('error', 'Marked leave exceeds available quota!');
            }

            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                switch ($LeaveRequest->leave_type) {
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
                if ($LeaveRequest->leave_type === "sick_leave") {
                    $status = 7;
                } elseif ($LeaveRequest->leave_type == "casual_leave") {
                    $status = 8;
                } elseif ($LeaveRequest->leave_type == "annual_leave") {
                    $status = 9;
                } elseif ($LeaveRequest->leave_type == "unpaid_leave") {
                    $status = 6;
                }
                $attendances[] = [
                    'user_id' => $LeaveRequest->user_id,
                    'check_in' => null,
                    'check_out' => null,
                    'status' => $status,
                    'created_at' => $date->toDateTimeString(),
                ];

                Leave::create([
                    'date' => $date,
                    'user_id' => $LeaveRequest->user_id,
                    'reason' => $LeaveRequest->reason,
                    'leave_type' => $status,
                    'reason' => $LeaveRequest->description
                ]);
            }
            Attendance::insert($attendances);
            $leaveQuota->save();

            LeaveRequest::find($id)->update([
                'status' => 1
            ]);
            $user = User::find($LeaveRequest->user_id);
            $users = User::where('id', $LeaveRequest->user_id)
                ->orWhereIn('designation_id', [1, 2])
                ->get();
            CustomHelper::SendNotification($users, 2, "$user->name leave request has been approved.");
            DB::commit();
            return back()->with('success', 'Leave Approved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return back()->with('error', 'Leave Approved successfully!');
        }
    }
    public function leaveRequestReject($id)
    {
        try {
            $LeaveRequest = LeaveRequest::find($id);
            $LeaveRequest->update([
                'status' => 0
            ]);
            $user = User::find($LeaveRequest->user_id);
            $users = User::where('id', $LeaveRequest->user_id)->orWhereIn('designation_id', [1, 2])->get();
            CustomHelper::SendNotification($users, 2, "$user->name leave request has been Rejected.");
            return back()->with('success', 'Leave Request Rejected Successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Leave Request Rejected Failed!');
        }
    }
}
