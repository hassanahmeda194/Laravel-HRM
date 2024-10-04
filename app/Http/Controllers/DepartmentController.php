<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('users')->orderByDesc('id')->get();
        return view('Departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'department_name' => 'required'
            ]);

            Department::create([
                'name' => $request->department_name,
                'is_active' => $request->filled('is_active')
            ]);

            return back()->with('success', 'Department added successfully!');
        } catch (\Exception $e) {
            Log::error('Department creation failed: ' . $e->getMessage());
            return back()->with('error', 'Department creation failed!');
        }
    }
    public function show(Department $department)
    {
        //
    }

    public function edit(Request $request)
    {
        $department = Department::findOrFail($request->id);
        return response()->json(['department' => $department]);
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'department_name' => 'required'
            ]);
            $department = Department::findOrFail($request->id);
            $department->update([
                'name' => $request->department_name,
                'is_active' => $request->filled('is_active')
            ]);
            return back()->with('success', 'Department updated successfully!');
        } catch (\Exception $e) {
            Log::error('Department update failed: ' . $e->getMessage());
            return back()->with('error', 'Department update failed!');
        }
    }
    public function destroy($id)
    {
        try {
            Department::findOrFail($id)->delete();
            return back()->with('success', 'Department deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Department deletion failed: ' . $e->getMessage());
            return back()->with('error', 'Department deletion failed!');
        }
    }
}
