<?php

use App\Http\Controllers\ChatGptController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home.index');
    Route::get('/test', 'test')->name('home.test');
});

Route::get('/single', [\App\Http\Controllers\TestController::class, '__invoke']);
Route::get('/contact', [\App\Http\Controllers\HomeController::class, 'contact'])->name('home.contact');
Route::get('/ai-chat', [\App\Http\Controllers\HomeController::class, 'aiChat'])->name('ai.chat');
Route::prefix('admin')->group(function () {
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'show' => 'admin.products.show',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);
    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class)
        ->only(['index', 'show'])
        ->names([
            'index' => 'admin.posts.index',
            'show' => 'admin.posts.show',
        ]);
});
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\LoginController;
Route::get('/register', [RegistrationController::class, 'showForm'])->name('register.form');
Route::post('/register', [RegistrationController::class, 'register'])->name('register');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
