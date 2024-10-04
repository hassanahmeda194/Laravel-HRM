<?php

namespace App\Models;

use App\Helpers\CustomHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'date'
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(function () {
            CustomHelper::createActionLog('created', 'add a new holiday', auth()->user()->id);
        });
        static::updated(function () {
            CustomHelper::createActionLog('update', 'update a holiday', auth()->user()->id);
        });
    }
}
