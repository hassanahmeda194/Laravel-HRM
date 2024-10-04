<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $candidates = Candidate::orderByDesc('id')->get();
        return view('candidate.index', compact('candidates'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "email" => "required|unique:candidates,email",
            "phone" => "required",
            "status" => "required|integer",
            "address" => "nullable",
            "resume_path" => "nullable|file",
        ]);

        try {
            $path = null;
            if ($request->hasFile('resume_path')) {
                $name = uniqid() . '.' . $request->resume_path->getClientOriginalName();
                $request->resume_path->move(public_path('candidate-resume/'), $name);
                $path = 'candidate-resume/' . $name;
            }
            Candidate::create([
                "name" => $request->name,
                "email" => $request->email,
                "phone" => $request->phone,
                "status" => $request->status,
                "address" => $request->address,
                "resume_path" => $path,
            ]);
            return back()->with('success', 'Candidate Added Successfully!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->with('error', 'Candidate Added Failed!');
        }
    }

    public function show(Candidate $candidate) {}

    public function edit(Request $request)
    {
        try {
            $candidate = Candidate::find($request->id);
            return view('partials.modals.candidate-edit-model', compact('candidate'))->render();
        } catch (\Throwable $th) {
            return back()->with('error', 'Candidate not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required|string",
            "email" => "required|unique:candidates,id,except," . $id,
            "phone" => "required",
            "status" => "required|integer",
            "address" => "nullable",
            "resume_path" => "sometimes",
        ]);

        try {
            $candidate = Candidate::find($id);
            $candidate->update([
                "name" => $request->name,
                "email" => $request->email,
                "phone" => $request->phone,
                "status" => $request->status,
                "address" => $request->address,
            ]);
            if ($request->hasFile('resume_path')) {
                $path = $request->file('resume_path')->store('candidate_resume');
                $candidate->resume_path = $path;
                $candidate->save();
            }
            return redirect()->back()->with('success', 'Candidate Updated Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Candidate Update Failed!');
        }
    }
    public function destroy($id)
    {
        try {
            Candidate::find($id)->delete();
            return back()->with('success', 'candidate deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'candidate deleted failed');
        }
    }
}
