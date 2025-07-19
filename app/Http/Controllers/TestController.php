<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    public function __invoke()
    {
        return 'Test Page';
    }
}
