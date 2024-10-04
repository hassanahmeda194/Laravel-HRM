<?php

namespace App\Models;

use App\Helpers\CustomHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBankDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_holder_name',
        'account_number',
        'IBAN',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::updated(function () {
            CustomHelper::createActionLog('update', 'bank detail', auth()->user()->id);
        });
    }
}
