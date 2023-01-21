<?php

namespace App\View\Composers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryComposer {
	final public function compose(View $view): void {
		$categories = Category::take(5)->latest()->get(['id', 'name']);
		$view->with(compact('categories'));
	}
}
