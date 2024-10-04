<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveQuota extends Model
{
    use HasFactory;
    protected $fillable = [
        'sick_leave', 'annual_leave', 'casual_leave', 'user_id', 'unpaid_leave'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
