<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NvidiaChatController;

Route::get('/ping', function() { return 'pong'; });
Route::post('/nvidia-chat', [NvidiaChatController::class, 'chat'])->middleware('web');
