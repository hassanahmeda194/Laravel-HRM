<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Attendance;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::pluck('id')->toArray();

        // $currentMonth = Carbon::now()->startOfMonth();
        $previousMonth = Carbon::now()->subMonth()->startOfMonth();
        $checkIn = '09:00';
        $checkOut = '17:00';

        foreach ($userIds as $userId) {
            $daysInMonth = $previousMonth->daysInMonth;
            for ($day = 1; $day <= $daysInMonth; $day++) {
                Attendance::create([
                    'user_id' => $userId,
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                    'created_at' => $previousMonth->copy()->addDays($day - 1),
                    'status' => 1,
                ]);
            }
        }
    }
}
