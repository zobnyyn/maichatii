<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        return View::make('home.index', ['title' => 'Home Page', ], compact('users')); // compact создаёт массив из переменных, без указания знака $ перед ними
    }

    public function aiChat(Request $request)
    {
        $title = 'Чат с ИИ';
        $userId = Auth::id();
        $sessionId = $request->session()->getId();
        if ($userId) {
            $history = ChatMessage::where('user_id', $userId)->orderBy('created_at', 'desc')->limit(30)->get()->reverse();
        } else {
            $history = ChatMessage::where('session_id', $sessionId)->orderBy('created_at', 'desc')->limit(30)->get()->reverse();
        }
        return view('home.ai-chat', compact('title', 'history'));
    }
}
