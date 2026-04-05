<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsMessage extends Model
{
    use HasFactory;

    protected $fillable = ['sender', 'content', 'app_name', 'received_at'];

    protected $casts = [
        'received_at' => 'datetime',
    ];
}
