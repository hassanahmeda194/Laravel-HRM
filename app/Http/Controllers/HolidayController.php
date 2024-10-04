<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HolidayController extends Controller
{

    public function index()
    {
        $holidays = Holiday::all();
        return view('Holiday.index', compact('holidays'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required|date',
        ]);
        DB::beginTransaction();
        try {
            $attendanceExist = Attendance::with('user')->whereDate('created_at', Carbon::parse($request->date)->format('Y-m-d'))->exists();
            if ($attendanceExist) {
                return back()->with('error', 'Attendance has already been marked for ' . $request->date);
            }
            $users = User::all();
            foreach ($users as $user) {
                $attendance = new Attendance();
                $attendance->user_id = $user->id;
                $attendance->check_in = '00:00';
                $attendance->check_out = '00:00';
                $attendance->status = 10;
                $attendance->created_at =  $request->date;
                $attendance->save();
            }
            Holiday::create([
                'name' => $request->name,
                'date' => $request->date,
            ]);
            DB::commit();
            return back()->with('success', 'Holiday added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to add holiday: ' . $e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        try {
            $holiday = Holiday::find($request->id);
            return response()->json($holiday);
        } catch (\Exception $e) {
            return response()->json('error', 'record not found!');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required|date',
        ]);
        DB::beginTransaction();
        try {
            $holiday = Holiday::find($request->id);
            $attendance = Attendance::whereDate('created_at', '=', Carbon::parse($holiday->date)->format('Y-m-d'))->delete();
            $holiday->update([
                'name' => $request->name,
                'date' => $request->date
            ]);
            $users = User::all();
            foreach ($users as $user) {
                $attendance = new Attendance();
                $attendance->user_id = $user->id;
                $attendance->check_in = '00:00';
                $attendance->check_out = '00:00';
                $attendance->status = 10;
                $attendance->created_at =  $request->date;
                $attendance->save();
            }
            DB::commit();
            return back()->with('success', 'Holiday Updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update holiday');
        }
    }

    public function destroy($id)
    {
        try {
            $holiday =  Holiday::find($id);
            Attendance::whereDate('created_at', $holiday->date)->delete();
            $holiday->delete();
            return back()->with('success', 'Holiday Deleted Successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Holiday Deleted Failed!');
        }
    }
}
