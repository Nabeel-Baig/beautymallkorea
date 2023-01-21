<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ManageProductRequest;
use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller {
	final public function manage(ManageProductRequest $request, ?Product $product): View {
		$data = $request->validated();
		$productData = $data["product"];

		$productData = handleFiles("products", $productData);

		if ($product === null) {
			$product = Product::create($productData);
		} else {
			$product->update($productData);
		}
	}
}
