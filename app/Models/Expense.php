<?php

namespace App\Models;

use App\Helpers\CustomHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',
        'amount',
        'description',
        'expense_date',
    ];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function () {
            CustomHelper::createActionLog('created', 'add a expense', auth()->user()->id);
        });
        static::updated(function () {
            CustomHelper::createActionLog('update', 'update a expense', auth()->user()->id);
        });
    }
}
