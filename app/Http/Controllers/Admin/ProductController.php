<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ManageProductRequest;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\TagService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller {
	private readonly string $title;

	public function __construct(
		private readonly ProductService $productService,
		private readonly TagService $tagService,
		private readonly CategoryService $categoryService,
	) {
		$this->title = "Products";
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function showManage(Product $product = null): View {
		$this->authorize("access", [Product::class, PermissionEnum::PRODUCT_MANAGE]);

		$content["title"] = $this->title;
		$content["tags"] = $this->tagService->getTagsForDropdown();
		$content["categories"] = $this->categoryService->getCategoriesForDropdown();
		$content["relatedProducts"] = $this->productService->getProductsForDropdown();


		$content["model"] = $product === null ? null : $this->productService->fetchProductDataForManagement($product);
		$content["assignedTags"] = $product === null ? [] : $content["model"]->tags->pluck("id")->toArray();
		$content["assignedCategories"] = $product === null ? [] : $content["model"]->categories->pluck("id")->toArray();
		$content["assignedRelatedProducts"] = $product === null ? [] : $content["model"]->relatedProducts->pluck("id")->toArray();
		return view("admin.products.manage")->with($content);
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function manage(ManageProductRequest $manageProductRequest, Product $product = null): RedirectResponse {
		$this->authorize("access", [Product::class, PermissionEnum::PRODUCT_MANAGE]);

		$this->productService->manage($manageProductRequest, $product);

		return redirect()->route("admin.products.index")->withUpdatedSuccessToastr("Product");
	}
}
