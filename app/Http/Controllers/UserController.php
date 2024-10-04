<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\Department;
use App\Models\Designation;
use App\Models\User;
use App\Services\EmployeeService;
use Asif160627\ZktecoAccessControl\Facades\AccessControl;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $employeeService;
    public function __construct(EmployeeService $EmployeeService)
    {
        $this->employeeService = $EmployeeService;
    }

    
    public function index()
    {
        $Users = User::with([
            'employee_leave',
            'designation',
            'employee_basic_info',
            'employement_info',
            'bank_details',
            'documents'
        ])->get();
        return view('Employees.index', compact('Users'));
    }

    public function create()
    {
        $Emp_ID = $this->employeeService->getEmployeeID();
        $designations = Designation::all();
        return view('Employees.create', compact('Emp_ID', 'designations'));
    }
    public function store(UserRequest $request)
    {
        try {
            $result = $this->employeeService->createUser($request);
            return redirect()->route('employee.index')->with('success', 'Employee added successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while processing the request.');
        }
    }

    public function show(string $id)
    {
        //
    }


    public function edit($id)
    {
        $user = User::with([
            'employee_leave',
            'designation',
            'employee_basic_info',
            'employement_info',
            'bank_details',
            'documents'
        ])->find($id);
        $designations = Designation::all();
        return view('Employees.edit', compact('user', 'designations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        try {
            $result = $this->employeeService->updateUser($request, $id);
            return redirect()->route('employee.index')->with('success', 'Employee updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while processing the request.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            User::where('id', $id)->delete();
            return back()->with('success', 'Employee deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete employee: ' . $e->getMessage());
        }
    }
}
