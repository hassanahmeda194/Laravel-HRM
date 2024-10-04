<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::all();
        return view('crm.branch.index', compact('branches'));
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
        $data = $request->validate(['name' => 'required', 'city' => 'required', 'country' => 'required']);
        try {
            Branch::create($data);
            return back()->with('success', 'Branch Added Successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Branch Added Failed!', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        try {
            return view('crm.branch.edit', ['branch' => $branch])->render();
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        $data = $request->validate(['name' => 'required', 'city' => 'required', 'country' => 'required']);
        try {
            $branch->update($data);
            return back()->with('success', 'Branch Updated Successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Branch Update Failed!', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        try {
            $branch->delete();
            return back()->with('success', 'Branch Deleted Successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Branch Deleted Failed!');
        }
    }
}
