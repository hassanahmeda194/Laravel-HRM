<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helpers\CustomHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use  HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'Emp_Id',
        'password',
        'is_active',
        'designation_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }
    public function employee_basic_info()
    {
        return $this->hasOne(EmployeeBasicInfo::class, 'user_id');
    }
    public function employement_info()
    {
        return $this->hasOne(EmploymentDetails::class, 'user_id');
    }
    public function bank_details()
    {
        return $this->hasOne(EmployeeBankDetail::class, 'user_id');
    }
    public function employee_leave()
    {
        return $this->hasOne(EmployeeLeave::class, 'user_id');
    }
    public function documents()
    {
        return $this->hasMany(Document::class, 'user_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'user_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function () {
            CustomHelper::createActionLog('create', 'user', auth()->user()->id);
        });
        static::updated(function () {
            CustomHelper::createActionLog('update', 'user', auth()->user()->id);
        });
        static::deleted(function () {
            CustomHelper::createActionLog('delete', 'user', auth()->user()->id);
        });
    }
}
