<?php

namespace App\Composers;
use Illuminate\View\View;

class TestComposer
{
    public function compose(View $view)
    {
        $view->with('count', 100);
    }
}
