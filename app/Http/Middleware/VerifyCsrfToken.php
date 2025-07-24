<?php
namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [ // $except нужно для исключения из проверки CSRF-токена
        'api/*',
        '/api/nvidia-chat',
    ];
}
