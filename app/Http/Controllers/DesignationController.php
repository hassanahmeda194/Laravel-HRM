<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::where('is_active', 1)->get();
        $designations = Designation::with('department')->get();
        return view('Designations.index', compact('departments', 'designations'));
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
            'designation_name' => 'required',
            'department_id' => 'required'
        ]);
        try {
            $designation = Designation::create([
                'name' => $request->designation_name,
                'department_id' => $request->department_id,
                'is_active' => $request->has('is_active')
            ]);
            if ($request->permissions) {
                $designation->permissions()->attach($request->permissions);
            }
            return redirect()->back()->with('success', 'Designation added successfully');
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('Designation faild' . $e->getMessage());
            return redirect()->back()->with('error', 'Designation added failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Designation $designation)
    {
        //
    }

    public function edit(Request $request)
    {
        try {
            $designation = Designation::with('permissions')->find($request->id);
            $departments = Department::all();
            return view('partials.modals.designation-edit-modal', compact('designation', 'departments'))->render();
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json(['success' => false, 'error' => 'Designation not found'], 404);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'designation_name' => 'required',
            'department_id' => 'required'
        ]);

        try {
            $designation = Designation::find($id);
            if (!$designation) {
                return redirect()->back()->with('error', 'Designation not found');
            }
            $designation->update([
                'name' => $request->designation_name,
                'department_id' => $request->department_id,
                'is_active' => $request->has('is_active')
            ]);

            if ($request->permissions) {
                $designation->permissions()->sync($request->permissions);
            }

            return redirect()->back()->with('success', 'Designation updated successfully');
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('Designation update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Designation update failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $designation = Designation::find($id);
            if (!$designation) {
                return redirect()->back()->with('error', 'Designation not found');
            }
            $designation->delete();
            return redirect()->route('designations.index')->with('success', 'Designation deleted successfully');
        } catch (\Exception $e) {
            Log::error('Designation deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Designation deletion failed');
        }
    }
}
