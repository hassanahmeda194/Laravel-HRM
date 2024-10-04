<?php

namespace App\Http\Controllers;

use App\Helpers\CustomHelper;
use App\Models\Candidate;
use App\Models\InterviewSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InterviewScheduleController extends Controller
{

    public function index()
    {
        $scheduleInterviews = InterviewSchedule::with(['candidate', 'interviewer'])->get();
        $candidates = Candidate::all();
        $interviewers = User::all();
        return view('interview-schedule.index', compact('scheduleInterviews', 'candidates', 'interviewers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required',
            'interview_datetime' => 'sometimes',
            'interview_type' => 'required',
            'status' => 'required',
            'interviewer_id' => 'required',
        ]);
        try {
            InterviewSchedule::create([
                'candidate_id' => $request->candidate_id,
                'interview_datetime' => $request->interview_datetime,
                'interview_type' => $request->interview_type,
                'status' => $request->status,
                'interviewer_id' => $request->interviewer_id,
            ]);
            $interviewDateTime = Carbon::parse($request->interview_datetime)->format('l, F j, Y \a\t h:i A');
            $interviewer = User::where('id', $request->interviewer_id)->whereIn('designation_id', [1, 2])->get();
            CustomHelper::SendNotification($interviewer, 1, "Your interview is scheduled for $interviewDateTime");
            return back()->with('success', 'Interview scheduled successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Interview scheduled Failed!');
        }
    }

    public function edit(Request $request)
    {
        try {
            $scheduleInterview = InterviewSchedule::with(['candidate', 'interviewer'])->find($request->id);
            $candidates = Candidate::all();
            $interviewers = User::all();
            return view('partials.modals.edit-interview', compact('scheduleInterview', 'candidates', 'interviewers'))->render();
        } catch (\Throwable $th) {
            return back()->with('error', 'Something wants wrong!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'candidate_id' => 'required',
            'interview_datetime' => 'required|nullable',
            'interview_type' => 'required',
            'status' => 'required',
            'interviewer_id' => 'required',
        ]);
        try {
            InterviewSchedule::find($id)->update([
                'candidate_id' => $request->candidate_id,
                'interview_datetime' => $request->interview_datetime,
                'interview_type' => $request->interview_type,
                'status' => $request->status,
                'interviewer_id' => $request->interviewer_id,
            ]);
            return back()->with('success', 'Interview scheduled Updated successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Interview scheduled Updated Failed!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            InterviewSchedule::find($id)->delete();
            return back()->with('success', 'Interview scheduled Deleted successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Interview scheduled Deleted Failed!');
        }
    }
}
