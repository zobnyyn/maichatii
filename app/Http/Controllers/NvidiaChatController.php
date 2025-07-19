<?php

namespace App\Http\Controllers;

use App\Services\NvidiaChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NvidiaChatController extends Controller
{
    protected $chatService;

    public function __construct(NvidiaChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function chat(Request $request)
    {
        $message = $request->input('message');
        if (!$message) {
            return response()->json(['error' => 'Нет сообщения'], 400);
        }

        $userId = Auth::id();
        $sessionId = $request->session()->getId();
        $history = $this->chatService->getHistory($userId, $sessionId);
        $messages = $this->chatService->buildMessages($history, $message);

        try {
            $response = $this->chatService->sendToNvidia($messages);
        } catch (\Throwable $e) {
            $this->chatService->saveMessage($message, null, $userId, $sessionId);
            return response()->json([
                'error' => 'Ошибка соединения с Nvidia API',
                'details' => $e->getMessage()
            ], 500);
        }

        if ($response->failed()) {
            $this->chatService->saveMessage($message, null, $userId, $sessionId);
            return response()->json([
                'error' => 'Ошибка Nvidia API',
                'details' => $response->body()
            ], 500);
        }

        $data = $response->json();
        $answer = $data['choices'][0]['message']['content'] ?? 'Нет ответа';
        $this->chatService->saveMessage($message, $answer, $userId, $sessionId);
        return response()->json(['answer' => $answer]);
    }
}
