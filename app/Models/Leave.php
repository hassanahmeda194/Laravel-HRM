<?php

namespace App\Models;

use App\Helpers\CustomHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'user_id',
        'reason',
        'leave_type'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function () {
            CustomHelper::createActionLog('create', 'leave', auth()->user()->id);
        });
        static::updated(function () {
            CustomHelper::createActionLog('update', 'leave', auth()->user()->id);
        });
        static::deleted(function () {
            CustomHelper::createActionLog('delete', 'leave', auth()->user()->id);
        });
    }
}
