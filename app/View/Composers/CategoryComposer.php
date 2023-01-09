<?php

namespace App\View\Composers;


use App\Models\Category;
use Illuminate\View\View;

class CategoryComposer
{

    final public function compose(View $view): void
    {
        try {
            $categories = Category::take(5)->latest()->get(['id', 'name']);
        } catch (\Exception $e)
        {
            dd('General Exception: '. $e->getMessage());
        }
        $view->with(compact('categories'));
    }
}
