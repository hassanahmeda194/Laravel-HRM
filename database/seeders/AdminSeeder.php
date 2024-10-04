<?php

namespace Database\Seeders;

use App\Models\EmployeeBankDetail;
use App\Models\EmployeeBasicInfo;
use App\Models\EmployeeLeave;
use App\Models\EmploymentDetails;
use App\Models\LeaveQuota;
use App\Models\User;
use App\Services\EmployeeService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'Emp_Id' => 'EMP-1',
                'is_active' => 1,
                'designation_id' => 1,
            ]);
            if ($user) {
                EmployeeBasicInfo::create([
                    'date_of_birth' => Carbon::now(),
                    'cnic' => '123465798',
                    'phone_number' => '123456798',
                    'address' => 'Main street new york',
                    'personal_email' => 'jhon@gmail.com',
                    'user_id' => $user->id,
                ]);

                EmploymentDetails::create([
                    'salary' => '10000',
                    'job_type' => 2,
                    'shift_start_time' => '09:00',
                    'shift_end_time' => '09:00',
                    'joining_date' => Carbon::now(),
                    'user_id' => $user->id,
                ]);

                EmployeeBankDetail::create([
                    'account_holder_name' => 'Jhon Deo',
                    'account_number' => '123456789',
                    'IBAN' => 'IBAN',
                    'user_id' => $user->id,
                ]);

                EmployeeLeave::create([
                    'sick_leave' => 0,
                    'casual_leave' => 0,
                    'annual_leave' => 0,
                    'user_id' => $user->id,
                ]);
                LeaveQuota::create([
                    'sick_leave' => 0,
                    'casual_leave' => 0,
                    'annual_leave' => 0,
                    'unpaid_leave' => 0,
                    'user_id' => $user->id,
                ]);
                DB::commit();
            } else {
                DB::rollBack();
            }
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
