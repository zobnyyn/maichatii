<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [ // этот массив определяет, какие поля модели могут быть массово присвоены
        'user_message',
        'bot_answer',
        'user_id',
        'session_id',
    ];
}
