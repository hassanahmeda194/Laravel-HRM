<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'file_path', 'user_id'
    ];
    protected function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
