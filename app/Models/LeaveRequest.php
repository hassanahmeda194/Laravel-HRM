<?php

namespace App\Models;

use App\Helpers\CustomHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'leave_type',
        'start_date',
        'end_date',
        'user_id',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    protected static function boot()
    {
        parent::boot();
        static::created(function () {
            CustomHelper::createActionLog('created', 'send a leave request', auth()->user()->id);
        });
        static::updated(function () {
            CustomHelper::createActionLog('update', 'update a leave request', auth()->user()->id);
        });
    }
}
