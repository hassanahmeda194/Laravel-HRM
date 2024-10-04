<?php

namespace App\Models;

use App\Helpers\CustomHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'priority',
        'status',
        'assigned_to',
    ];

    // Relationships
    public function responses()
    {
        return $this->hasMany(TicketResponse::class);
    }

    public function attachments()
    {
        return $this->hasMany(TicketAttachment::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function () {
            CustomHelper::createActionLog('created', 'add a ticket', auth()->user()->id);
        });
        static::updated(function () {
            CustomHelper::createActionLog('update', 'update a ticket', auth()->user()->id);
        });
    }
}
