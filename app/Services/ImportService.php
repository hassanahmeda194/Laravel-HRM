<?php

namespace App\Services;

use App\Imports\EmployeesImport;
use App\Models\Allowance;
use App\Models\Candidate;
use App\Models\Department;
use App\Models\Designation;
use App\Models\EmployeeBankDetail;
use App\Models\EmployeeBasicInfo;
use App\Models\EmploymentDetails;
use App\Models\LeaveQuota;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\Catch_;

class ImportService
{
    public  $employeeService;
    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }
    public function importEmployee(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);
        DB::beginTransaction();
        try {
            $data = Excel::toCollection(null, $request->file('file'));
            $rows = $data[0];
            foreach ($rows as $index => $row) {
                if ($index === 0) continue;
                $user = User::create([
                    'name' => $row[0], // Name
                    'email' => $row[1], // Email
                    'password' => Hash::make($row[2]), // Password (hashed)
                    'Emp_Id' => $this->employeeService->getEmployeeID(), // Generate Emp_Id
                    'is_active' => true, // Set default value or adjust as needed
                    'designation_id' => $this->getDesignationId($row[3]), // Assuming you have a method to get designation ID
                ]);
                if ($user) {
                    EmployeeBasicInfo::create([
                        'date_of_birth' => $row[4] ?? null,
                        'cnic' => $row[5] ?? null,
                        'phone_number' => $row[6] ?? null,
                        'address' => $row[7] ?? null,
                        'personal_email' => $row[8] ?? null,
                        'profile_image' => null, // Adjust if you have a profile image
                        'user_id' => $user->id,
                    ]);
                    EmploymentDetails::create([
                        'salary' => $row[9] ?? null,
                        'job_type' => $row[10] ?? null,
                        'shift_start_time' => $row[11] ?? null,
                        'shift_end_time' => $row[12] ?? null,
                        'joining_date' => $row[13] ?? null,
                        'flexible_timing' => $row[14] == "1" ? true : false,
                        'user_id' => $user->id,
                    ]);
                    EmployeeBankDetail::create([
                        'account_holder_name' => $row[15] ?? null,
                        'account_number' => $row[16] ?? null,
                        'IBAN' => $row[17] ?? null,
                        'user_id' => $user->id,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('employee.index')->with('success', 'Employees added successfully');
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return back()->with('error', 'An error occurred while processing the request: ' . $e->getMessage());
        }
    }

    private function getDesignationId($designationName)
    {
        return \App\Models\Designation::where('name', $designationName)->value('id');
    }

    public function importDepartments(Request $request)
    {
        try {
            $data = Excel::toCollection(null, $request->file('file'));
            $rows = $data[0];
            foreach ($rows as $index => $row) {
                if ($index === 0) continue;
                Department::create([
                    'name' => $row[0],
                    'is_active' => $row[1]
                ]);
            }
            return back()->with('success', "Department file imported successfully!");
        } catch (\Throwable $th) {
            return back()->with('error', "Department file imported Failed!" . $th->getMessage());
        }
    }

    public function importDesignation(Request $request)
    {
        try {
            $data = Excel::toCollection(null, $request->file('file'));
            $rows = $data[0];
            foreach ($rows as $index => $row) {
                if ($index === 0) continue;
                Designation::create([
                    'name' => $row[0],
                    'department_id' => $this->getDepartmentID($row[2]),
                    'is_active' => $row[1]
                ]);
            }
            return back()->with('success', "Designation file imported successfully!");
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('error', "Designation file imported Failed!" . $th->getMessage());
        }
    }
    private function getDepartmentID($name)
    {
        $department_name = Department::where('name', $name)->first();
        return $department_name->id;
    }

    public function importCandidate(Request $request)
    {
        try {
            $data = Excel::toCollection(null, $request->file('file'));
            $rows = $data[0];
            foreach ($rows as $index => $row) {
                if ($index === 0) continue;
                Candidate::create([
                    "name" => $row[0],
                    "email" => $row[1],
                    "phone" => $row[2],
                    "status" => $this->getCandidateFunction($row[3]),
                    "address" => $row[4],
                ]);
            }
            return back()->with('success', "Candidate Data imported Successfully!");
        } catch (\Throwable $th) {
            return back()->with('error', "Candidate Data imported Failed!" . $th->getMessage());
        }
    }
    private function getCandidateFunction($status)
    {
        switch ($status) {
            case "In Process":
                return 1;
                break;
            case "Selected":
                return 2;
                break;
            case "Rejected":
                return 3;
                break;
            case "On Hold":
                return 4;
                break;
            default:
                return 0;
                break;
        }
    }

    public function importAllowances(Request $request)
    {
        try {
            $data = Excel::toCollection(null, $request->file('file'));
            $rows = $data[0];
            foreach ($rows as $index => $row) {
                if ($index === 0) continue;
                // Allowance::create([
                //     'month' => ,
                //     'name' => ,
                //     'amount' => ,
                //     'user_id' => ,
                //     'every_month' => 
                // ]);
            }
            return back()->with('success', "Allowance Data imported successfully!");
        } catch (\Throwable $th) {
            return back()->with('success', "Allowance Data imported Failed!" . $th->getMessage());
        }
    }

    public function importAllowance(Request $request)
    {
        try {
            $data = Excel::toCollection(null, $request->file('file'));
            $rows = $data[0];
            foreach ($rows as $index => $row) {
                if ($index === 0) continue;
                if ($row[3] == 'Y') {
                    foreach (User::all() as $user) {
                        Allowance::create([
                            'month' => Carbon::parse($row[4]),
                            'name' => $row[0],
                            'amount' => $row[1],
                            'user_id' => $user->id,
                            'every_month' => $row[5] == 'Y' ? 1 : 0
                        ]);
                    }
                } else {
                    Allowance::create([
                        'month' => Carbon::parse($row[4]),
                        'name' => $row[0],
                        'amount' => $row[1],
                        'user_id' => $this->getIdFromEmployeeID($row[2]) ?? null,
                        'every_month' => $row[5] == 'Y' ? 1 : 0
                    ]);
                }
            }
            return back()->with('success', 'Allowance Data imported successfully!');
        } catch (\Throwable $th) {
            return back()->with('success', 'Allowance Data imported Failed!' . $th->getMessage());
        }
    }

    public function getIdFromEmployeeID($emp_id)
    {
        $user = User::where('Emp_Id', $emp_id)->first();
        return $user->id;
    }
}
