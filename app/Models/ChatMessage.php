<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'user_message',
        'bot_answer',
        'user_id',
        'session_id',
    ];
}
