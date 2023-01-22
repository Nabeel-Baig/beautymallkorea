<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryService {
	final public function getCategoriesForDropdown(): Collection {
		return Category::select(["id", "name"])->get();
	}
}
