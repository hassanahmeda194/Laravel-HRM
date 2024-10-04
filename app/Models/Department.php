<?php

namespace App\Models;

use App\Helpers\CustomHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'is_active'
    ];

    public function designations()
    {
        return $this->hasMany(Designation::class, 'department_id');
    }
    public function users()
    {
        return $this->hasManyThrough(User::class, Designation::class, 'department_id', 'designation_id', 'id', 'id');
    }

    public function userCount()
    {
        return $this->users()->count();
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function () {
            CustomHelper::createActionLog('create', 'unit', auth()->user()->id);
        });
        static::updated(function () {
            CustomHelper::createActionLog('update', 'unit', auth()->user()->id);
        });
        static::deleted(function () {
            CustomHelper::createActionLog('delete', 'unit', auth()->user()->id);
        });
    }
}
