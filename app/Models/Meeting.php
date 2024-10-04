<?php

namespace App\Models;

use App\Helpers\CustomHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'date_time',
        'arranged_by',
    ];

    /**
     * Get the user who arranged the meeting.
     */
    public function arranger()
    {
        return $this->belongsTo(User::class, 'arranged_by');
    }

    /**
     * Get the participants of the meeting.
     */
    public function participants()
    {
        return $this->hasMany(MeetingParticipant::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function () {
            CustomHelper::createActionLog('created', 'add a meeting', auth()->user()->id);
        });
        static::updated(function () {
            CustomHelper::createActionLog('update', 'update a meeting', auth()->user()->id);
        });
    }
}
