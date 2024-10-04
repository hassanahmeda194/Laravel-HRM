<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'meeting_id',
    ];

    /**
     * Get the user associated with this participant record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the meeting associated with this participant record.
     */
    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }
}
