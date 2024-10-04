<?php

namespace App\Models;

use App\Helpers\CustomHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function () {
            CustomHelper::createActionLog('created', 'add a expense category', auth()->user()->id);
        });
        static::updated(function () {
            CustomHelper::createActionLog('update', 'update a expense category', auth()->user()->id);
        });
    }
}
