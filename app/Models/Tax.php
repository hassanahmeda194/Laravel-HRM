<?php

namespace App\Models;

use App\Helpers\CustomHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'rate'
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(function () {
            CustomHelper::createActionLog('created', 'add a tax', auth()->user()->id);
        });
        static::updated(function () {
            CustomHelper::createActionLog('update', 'update a tax', auth()->user()->id);
        });
    }
}
