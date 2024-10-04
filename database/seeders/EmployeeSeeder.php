<?php

namespace Database\Seeders;

use App\Models\EmployeeBankDetail;
use App\Models\EmployeeBasicInfo;
use App\Models\EmployeeLeave;
use App\Models\EmploymentDetails;
use App\Models\LeaveQuota;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeeSeeder extends Seeder
{
    use WithoutModelEvents;

    function getNewEmployeeID()
    {
        $latestEmployee = User::orderByDesc('id')->first();
        $currentNumber = $latestEmployee ? $latestEmployee->id + 1 : 1;
        return 'EMP-' . $currentNumber;
    }

    public function run()
    {
        // Employee data
        $employees = [
            ['name' => 'Rizwan Sheikh', 'email' => 'rizwan.shaikh@nextacllc.org', 'skype_id' => 'rizwan.shaikh@nextacllc.org', 'shift_start' => '9:00 AM', 'shift_end' => '6:00 PM', 'phone_number' => '92 3333350935'],
            ['name' => 'Saifuddin', 'email' => 'saifuddin.mehboob@nextacllc.org', 'skype_id' => 'saifuddin.mehboob@nextacllc.org', 'shift_start' => '9:00 AM', 'shift_end' => '6:00 PM', 'phone_number' => '92 3332484049'],
            ['name' => 'Aniq Aqib', 'email' => 'aniq.abid@nextacllc.org', 'skype_id' => 'aniq.abid@nextacllc.org', 'shift_start' => '12:00 PM', 'shift_end' => '9:00 PM', 'phone_number' => '92 317 2707288'],
            ['name' => 'Rafay Rajput', 'email' => 'rafay.rajput@nextacllc.org', 'skype_id' => 'rafay.rajput@nextacllc.org', 'shift_start' => '12:00 PM', 'shift_end' => '9:00 PM', 'phone_number' => '92 318 2566674'],
            ['name' => 'Nabeel Khan', 'email' => 'nabeel.khan@nextacllc.org', 'skype_id' => 'nabeel.khan@nextacllc.org', 'shift_start' => '12:00 PM', 'shift_end' => '9:00 PM', 'phone_number' => '92 340 2382998'],
            ['name' => 'S.M. Usama Uddin', 'email' => 'usama.uddin@nextacllc.org', 'skype_id' => 'usama.uddin@nextacllc.org', 'shift_start' => '1:00 PM', 'shift_end' => '10:00 PM', 'phone_number' => '92 3162870064'],
            ['name' => 'Motahashim Abdul Gaffar', 'email' => 'Mohtashim.abdul@nextacllc.org', 'skype_id' => 'Mohtashim.abdul@nextacllc.org', 'shift_start' => '12:00 PM', 'shift_end' => '9:00 PM', 'phone_number' => '92 301 2633600'],
            ['name' => 'Sharjeel Ahmed', 'email' => 'sharjeel@nextacllc.org', 'skype_id' => 'sharjeel@nextacllc.org', 'shift_start' => '12:00 PM', 'shift_end' => '9:00 PM', 'phone_number' => '92 311 2799628'],
            ['name' => 'Basit Naseem', 'email' => 'basit.naseem@nextacllc.org', 'skype_id' => 'basit.naseem@nextacllc.org', 'shift_start' => '11:00 AM', 'shift_end' => '8:00 AM', 'phone_number' => '92 308 2844341'],
            ['name' => 'Gurmeet Singh', 'email' => 'gurmeet.singh@nextacllc.org', 'skype_id' => 'gurmeet.singh@nextacllc.org', 'shift_start' => '8:00 PM', 'shift_end' => '5:00 PM', 'phone_number' => '92 330 2973432'],
            ['name' => 'M. Shahzaib', 'email' => 'm.shahzaib@nextacllc.org', 'skype_id' => 'm.shahzaib@nextacllc.org', 'shift_start' => '12:00 PM', 'shift_end' => '9:00 PM', 'phone_number' => '92 312 2319355'],
            ['name' => 'Hassan Ahmed', 'email' => 'hassan.ahmed@nextacllc.org', 'skype_id' => 'hassan.ahmed@nextacllc.org', 'shift_start' => '8:00 PM', 'shift_end' => '5:00 AM', 'phone_number' => '92 313 6529768'],
            ['name' => 'Muhammad Ahsan', 'email' => 'muhammad.ahsan@nextacllc.org', 'skype_id' => 'muhammad.ahsan@nextacllc.org', 'shift_start' => '8:00 PM', 'shift_end' => '5:00 AM', 'phone_number' => '92 304 1255309'],
            ['name' => 'Ayesha Ali', 'email' => 'ayesha.ali@nextacllc.org', 'skype_id' => 'ayesha.ali@nextacllc.org', 'shift_start' => '8:00 PM', 'shift_end' => '5:00 AM', 'phone_number' => '92 335 2022527'],
            ['name' => 'Victor Jhon Bhatti', 'email' => 'victor.john@nextacllc.org', 'skype_id' => 'victor.john@nextacllc.org', 'shift_start' => '8:00 PM', 'shift_end' => '5:00 AM', 'phone_number' => '92 332 8283946'],
            ['name' => 'M Uzair', 'email' => 'm.uzair@nextacllc.org', 'skype_id' => 'm.uzair@nextacllc.org', 'shift_start' => '8:00 PM', 'shift_end' => '5:00 AM', 'phone_number' => '92 316 2711816'],
            ['name' => 'M. Bilal', 'email' => 'muhammad.bilal@nextacllc.org', 'skype_id' => 'muhammad.bilal@nextacllc.org', 'shift_start' => '9:00 PM', 'shift_end' => '6:00 AM', 'phone_number' => '92 3333010020'],
            ['name' => 'Shoaib Ali', 'email' => 'shoaib.ali@nextacllc.org', 'skype_id' => 'shoaib.ali@nextacllc.org', 'shift_start' => '8:00 PM', 'shift_end' => '5:00 AM', 'phone_number' => '92 302 2414267'],
            ['name' => 'Munzallin Munaf', 'email' => 'munzallin.munaf@nextacllc.org', 'skype_id' => 'munzallin.munaf@nextacllc.org', 'shift_start' => '9:00 AM', 'shift_end' => '6:00 PM', 'phone_number' => '92 334 3909636'],
            ['name' => 'Abdullah Munaf', 'email' => 'abdullah.munaf@nextacllc.org', 'skype_id' => 'abdullah.munaf@nextacllc.org', 'shift_start' => '10:00 PM', 'shift_end' => '5:00 AM', 'phone_number' => '92 318 1009130'],
            ['name' => 'Maham Khalid', 'email' => 'maham.khalid@nextacllc.org', 'skype_id' => 'maham.khalid@nextacllc.org', 'shift_start' => '9:00 AM', 'shift_end' => '6:00 PM', 'phone_number' => '92 343 2624092'],
        ];

        DB::beginTransaction();
        try {
            foreach ($employees as $employee) {
                $user = User::create([
                    'name' => $employee['name'],
                    'email' => $employee['email'],
                    'password' => Hash::make('password'), 
                    'Emp_Id' => $this->getNewEmployeeID(),
                    'is_active' => 1,
                    'designation_id' => 1, 
                ]);
                if ($user) {
                    EmployeeBasicInfo::create([
                        'date_of_birth' => Carbon::parse('1990-01-01'), //
                        'cnic' => '123456789',
                        'phone_number' => $employee['phone_number'],
                        'address' => 'Street 1, City Name', // 
                        'personal_email' => $employee['email'],
                        'user_id' => $user->id,
                    ]);
                    EmploymentDetails::create([
                        'salary' => '00000',
                        'job_type' => 2,
                        'shift_start_time' => date('H:i:s', strtotime($employee['shift_start'])), 
                        'shift_end_time' => date('H:i:s', strtotime($employee['shift_end'])), 
                        'flexible_timing' => false,
                        'joining_date' => Carbon::now(),
                        'user_id' => $user->id,
                    ]);
                    EmployeeBankDetail::create([
                        'account_holder_name' => $employee['name'],
                        'account_number' => '123456789', 
                        'IBAN' => 'PK00BANK000000123456789', 
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
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
