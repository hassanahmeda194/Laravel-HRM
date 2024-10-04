<?php

namespace App\Services;

use App\Models\Document;
use App\Models\EmployeeBankDetail;
use App\Models\EmployeeBasicInfo;
use App\Models\EmployeeLeave;
use App\Models\EmploymentDetails;
use App\Models\LeaveQuota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeService
{
    public function createUser($request)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'Emp_Id' => $this->getEmployeeID(),
                'is_active' => $request->filled('is_active'),
                'designation_id' => $request->designation_id,
            ]);

            if ($user) {
                $path = null;
                if ($request->hasFile('profile_image')) {
                    $path = $request->file('profile_image')->store('profile_images');
                }
                EmployeeBasicInfo::create([
                    'date_of_birth' => $request->date_of_birth ?? null,
                    'cnic' => $request->cnic ?? null,
                    'phone_number' => $request->phone_number ?? null,
                    'address' => $request->address ?? null,
                    'personal_email' => $request->personal_email ?? null,
                    'profile_image' => $path ?? null,
                    'user_id' => $user->id,
                ]);
                EmploymentDetails::create([
                    'salary' => $request->salary ?? null,
                    'job_type' => $request->job_type ?? null,
                    'shift_start_time' => $request->shift_start_timing ?? null,
                    'shift_end_time' => $request->shift_end_timing ?? null,
                    'joining_date' => $request->joining_date ?? null,
                    'flexible_timing' => $request->flexible_timing == "1" ? true : false,
                    'user_id' => $user->id, 
                ]);
                EmployeeBankDetail::create([
                    'account_holder_name' => $request->account_holder_name ?? null,
                    'account_number' => $request->account_number ?? null,
                    'IBAN' => $request->IBAN ?? null,
                    'user_id' => $user->id,
                ]);
                EmployeeLeave::create([
                    'sick_leave' => $request->sick_leave ?? 0,
                    'casual_leave' => $request->casual_leave ?? 0,
                    'annual_leave' => $request->annual_leave ?? 0,
                    'user_id' => $user->id,
                ]);
                LeaveQuota::create([
                    'sick_leave' => $request->sick_leave ?? 0,
                    'casual_leave' => $request->casual_leave ?? 0,
                    'annual_leave' => $request->annual_leave ?? 0,
                    'unpaid_leave' => 0,
                    'user_id' => $user->id,
                ]);
                if ($request->hasFile('documents')) {
                    foreach ($request->file('documents') as $document) {
                        $filePath = $document->store('documents');
                        $document = Document::create([
                            'user_id' => $user->id,
                            'file_path' => $filePath,
                            'name' => $document->getClientOriginalName()
                        ]);
                    }
                }
                DB::commit();
                return redirect()->route('employee.index')->with('success', 'Employee added successfully');
            } else {
                DB::rollBack();
                return back()->with('error', 'User registration failed!');
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return back()->with('error', 'An error occurred while processing the request.');
        }
    }

    public function getEmployeeID()
    {
        $latestEmployee = User::orderByDesc('id')->first();
        $currentNumber = $latestEmployee ? $latestEmployee->id + 1 : 1;
        return 'EMP-' . $currentNumber;
    }

    public function delete_document($id)
    {
        try {
            $document = Document::find($id);
            $document->delete();
            return back()->with('success', 'Document deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Document deletion failed!');
        }
    }

    public function profile_page($id)
    {
        if ($id != Auth::user()->id) {
            return back()->with('error', 'Not Authorized!');
        }
        $user = User::with([
            'designation',
            'employee_basic_info',
            'employement_info',
            'bank_details',
        ])->find($id);
        return view('Employees.profile', compact('user'));
    }

    public function update_personal_information(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'date_of_birth' => 'required',
            'cnic' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'personal_email' => 'required',
            'profile_image' => 'image',
        ]);

        try {
            $user = EmployeeBasicInfo::where('user_id', $request->user_id)->firstOrFail();
            if ($user->user_id != Auth::id()) {
                return back()->with('error', 'Not Authorized!');
            }
            $user->update([
                'date_of_birth' => $request->date_of_birth,
                'cnic' => $request->cnic,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'personal_email' => $request->personal_email,
            ]);

            if ($request->hasFile('profile_image')) {
                $path = $request->file('profile_image')->store('profile_images');
                $user->profile_image = $path;
                $user->save();
            }
            return back()->with('success', 'Personal information updated successfully');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->with('error', 'Personal Information Updation failed');
        }
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'password' => 'required|confirmed'
        ]);
        try {
            User::find($request->user_id)->update([
                'password' => Hash::make($request->password)
            ]);
            return back()->with('success', 'password updated successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', 'password updated failed!');
        }
    }

    public function bank_details(Request $request)
    {
        $request->validate([
            'account_holder_name' => 'required',
            'account_number' => 'required',
            'IBAN' => 'required',
            'user_id' => 'required',
        ]);

        try {
            EmployeeBankDetail::find($request->user_id)->update([
                'account_holder_name' => $request->account_holder_name,
                'account_number' => $request->account_number,
                'IBAN' => $request->IBAN,
            ]);
            return back()->with('success', 'bank details updated successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', 'bank details updated failed!');
        }
    }
    
     public function updateUser(Request $request, $id)
    {
        DB::beginTransaction();
        try {
                $user = User::findOrFail($id);
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'is_active' => $request->filled('is_active'),
                    'designation_id' => $request->designation_id,
                ]);
                if ($request->filled('password')) {
                    $user->password = Hash::make($request->password);
                    $user->save();
                }
                
            if ($request->hasFile('profile_image')) {
                $path = $request->file('profile_image')->store('profile_images');
                EmployeeBasicInfo::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'date_of_birth' => $request->date_of_birth ?? null,
                        'cnic' => $request->cnic ?? null,
                        'phone_number' => $request->phone_number ?? null,
                        'address' => $request->address ?? null,
                        'personal_email' => $request->personal_email ?? null,
                        'profile_image' => $path,
                    ]
                );
            } else {
                EmployeeBasicInfo::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'date_of_birth' => $request->date_of_birth ?? null,
                        'cnic' => $request->cnic ?? null,
                        'phone_number' => $request->phone_number ?? null,
                        'address' => $request->address ?? null,
                        'personal_email' => $request->personal_email ?? null,
                    ]
                );
            }
            EmploymentDetails::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'salary' => $request->salary ?? null,
                    'job_type' => $request->job_type ?? null,
                    'shift_start_time' => $request->shift_start_timing ?? null,
                    'shift_end_time' => $request->shift_end_timing ?? null,
                    'joining_date' => $request->joining_date ?? null,
                ]
            );
            EmployeeBankDetail::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'account_holder_name' => $request->account_holder_name ?? null,
                    'account_number' => $request->account_number ?? null,
                    'IBAN' => $request->IBAN ?? null,
                ]
            );
            EmployeeLeave::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'sick_leave' => $request->sick_leave ?? 0,
                    'casual_leave' => $request->casual_leave ?? 0,
                    'annual_leave' => $request->annual_leave ?? 0,
                ]
            );
            LeaveQuota::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'sick_leave' => $request->sick_leave ?? 0,
                    'casual_leave' => $request->casual_leave ?? 0,
                    'annual_leave' => $request->annual_leave ?? 0,
                    'unpaid_leave' => 0,
                ]
            );
            if ($request->hasFile('documents')) {
                Document::where('user_id', $user->id)->delete();
                foreach ($request->file('documents') as $document) {
                    $filePath = $document->store('documents');
                    Document::create([
                        'user_id' => $user->id,
                        'file_path' => $filePath,
                        'name' => $document->getClientOriginalName(),
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('employee.index')->with('success', 'Employee updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while processing the request.');
        }
    }
}
