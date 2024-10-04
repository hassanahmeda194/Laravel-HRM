<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class MarkAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mark-attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $isSunday = $today->isSunday();
     
        $users = User::all();
        foreach ($users as $user) {
            $attendanceCount = Attendance::where('user_id', $user->id)
                ->whereDate('created_at', $today)
                ->count();
            if ($attendanceCount === 0) {
                 Attendance::create([
                    'user_id' => $user->id,
                    'check_in' => null,
                    'check_out' => null,
                    'status' => 0
                ]);
                $this->info("Attendance entry created");
            } else {
                $this->info("Attendance entry already exists");
            }
        }
    }
}
