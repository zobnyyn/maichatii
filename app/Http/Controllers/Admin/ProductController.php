<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class ProductController extends Controller
{
    public function index() // Этот метод отображает список всех продуктов
    {
        route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
        return 'Product Index Page';
    }

    public function create() // Этот метод показывает форму создания нового продукта
    {
        return 'Create Product Page';
    }

    public function store(Request $request) // Этот метод обрабатывает отправку формы создания продукта и сохраняет новый продукт
    {
        // Logic to store the product
        return 'Product Stored Successfully';
    }

    public function show($id) // Этот метод отображает информацию о конкретном продукте по его ID
    {
        return "Showing Product with ID: $id";
    }

    public function edit($id) // Этот метод показывает форму редактирования продукта по его ID
    {
        return "Editing Product with ID: $id";
    }

    public function update(Request $request, $id) // Этот метод обрабатывает отправку формы редактирования и обновляет продукт
    {
        // Logic to update the product
        return "Product with ID: $id Updated Successfully";
    }

    public function destroy($id) // Этот метод удаляет продукт по его ID
    {
        // Logic to delete the product
        return "Product with ID: $id Deleted Successfully";
    }
}
