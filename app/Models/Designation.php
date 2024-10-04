<?php

namespace App\Models;

use App\Helpers\CustomHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Designation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'department_id',
        'is_active'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
    }
    
    protected static function boot()
    {
        parent::boot();
        static::created(function () {
            CustomHelper::createActionLog('create', 'role', auth()->user()->id);
        });
        static::updated(function () {
            CustomHelper::createActionLog('update', 'role', auth()->user()->id);
        });
        static::deleted(function () {
            CustomHelper::createActionLog('delete', 'role', auth()->user()->id);
        });
    }
}
