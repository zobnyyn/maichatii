<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Отображает список всех постов.
     */
    public function index()
    {
        // ...
    }

    /**
     * Показывает форму для создания нового поста.
     */
    public function create()
    {
        // ...
    }

    /**
     * Сохраняет новый пост в базе данных.
     */
    public function store(Request $request)
    {
        // ...
    }

    /**
     * Отображает конкретный пост по его ID.
     */
    public function show(string $id)
    {
        // ...
    }

    /**
     * Показывает форму для редактирования поста.
     */
    public function edit(string $id)
    {
        // ...
    }

    /**
     * Обновляет существующий пост в базе данных.
     */
    public function update(Request $request, string $id)
    {
        // ...
    }

    /**
     * Удаляет пост из базы данных.
     */
    public function destroy(string $id)
    {
        // ...
    }
}
