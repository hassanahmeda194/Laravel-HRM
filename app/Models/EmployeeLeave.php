<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeave extends Model
{
    use HasFactory;
    protected $fillable = [
        'sick_leave',
        'casual_leave',
        'annual_leave',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
