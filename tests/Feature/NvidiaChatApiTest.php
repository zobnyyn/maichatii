<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NvidiaChatApiTest extends TestCase
{
    /** @test */
    public function nvidia_chat_route_exists_and_returns_error_without_message()
    {
        $response = $this->postJson('/api/nvidia-chat', []);
        $response->assertStatus(400);
        $response->assertJsonStructure(['error']);
    }

    /** @test */
    public function nvidia_chat_route_returns_answer_for_valid_message()
    {
        // Можно замокать внешний запрос, если используется Http::fake()
        // Здесь просто проверяем, что маршрут существует и не 404
        $response = $this->postJson('/api/nvidia-chat', ['message' => 'Привет, бот!']);
        $this->assertTrue(in_array($response->getStatusCode(), [200, 500])); // 500 если нет доступа к Nvidia API
        $response->assertJsonStructure(['answer']);
    }
}

