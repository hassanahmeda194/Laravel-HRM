<?php

namespace App\Models;

use App\Helpers\CustomHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBasicInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'date_of_birth',
        'cnic',
        'phone_number',
        'address',
        'personal_email',
        'profile_image',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function DateOfBirth(): Attribute
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
            CustomHelper::createActionLog('update', 'personal detail', auth()->user()->id);
        });
    }
}
