<?php

namespace App\Models;

use App\Helpers\CustomHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'value',
        'purchase_date',
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(function () {
            CustomHelper::createActionLog('created', 'add a assets', auth()->user()->id);
        });
        static::updated(function () {
            CustomHelper::createActionLog('update', 'update a assets', auth()->user()->id);
        });
    }
}
