<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\MeetingParticipant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meetings = Meeting::with('participants.user')->OrderByDesc('id')->get();
        $users = User::all();
        return view('meeting.index', compact('meetings', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date_time' => 'required',
            'arranged_by' => 'required|exists:users,id',
            'arranged_with' => 'required|array',
            'arranged_with.*' => 'exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            $meeting = Meeting::create([
                'title' => $request->title,
                'description' => $request->description,
                'date_time' => $request->date_time,
                'arranged_by' => $request->arranged_by,
            ]);
            foreach ($request->arranged_with as $participantId) {
                $meeting->participants()->create(['user_id' => $participantId]);
            }
            DB::commit();
            return back()->with('success', 'Meeting scheduled successfully!');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            DB::rollBack();
            return back()->with('error', 'Meeting failed to schedule! Error: ' . $th->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Meeting $meeting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $meeting = Meeting::with('participants.user')->find($request->id);
        $users = User::all();
        return view('meeting.edit', compact('meeting', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date_time' => 'required',
            'arranged_by' => 'required|exists:users,id',
            'arranged_with' => 'required|array',
            'arranged_with.*' => 'exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            $meeting = Meeting::find($id);
            $meeting->update([
                'title' => $request->title,
                'description' => $request->description,
                'date_time' => $request->date_time,
                'arranged_by' => $request->arranged_by,
            ]);
            $meeting->participants()->delete();
            foreach ($request->arranged_with as $participantId) {
                $meeting->participants()->create(['user_id' => $participantId]);
            }
            DB::commit();
            return back()->with('success', 'Meeting scheduled successfully!');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            DB::rollBack();
            return back()->with('error', 'Meeting failed to schedule! Error: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            Meeting::find($id)->delete();
            return back()->with('success', "meeting deleted successfully!");
        } catch (\Throwable $th) {
            return back()->with('error', "meeting deleted failed!");
        }
    }
}
