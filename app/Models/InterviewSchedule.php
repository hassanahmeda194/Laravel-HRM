<?php

namespace App\Models;

use App\Helpers\CustomHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterviewSchedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'candidate_id',
        'interview_datetime',
        'interview_type',
        'status',
        'interviewer_id',
    ];

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }
    public function interviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'interviewer_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function () {
            CustomHelper::createActionLog('created', 'schedule a interview', auth()->user()->id);
        });
        static::updated(function () {
            CustomHelper::createActionLog('update', 'update a scheduled interview', auth()->user()->id);
        });
    }
}
