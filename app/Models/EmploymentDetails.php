<?php

namespace App\Models;

use App\Helpers\CustomHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploymentDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'salary',
        'job_type',
        'shift_start_time',
        'shift_end_time',
        'flexible_timing',
        'joining_date',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function joiningDate(): Attribute
    {
        return new Attribute(
            set: fn($value) => date('Y-m-d', strtotime($value)),
            get: fn($value) => date('F d, Y', strToTime($value)),
        );
    }

    protected static function boot()
    {
        parent::boot();
        static::updated(function () {
            CustomHelper::createActionLog('update', 'employment detail', auth()->user()->id);
        });
    }
}
