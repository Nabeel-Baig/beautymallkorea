<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ManageProductRequest;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\OptionService;
use App\Services\ProductService;
use App\Services\TagService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller {
	private readonly string $title;

	public function __construct(
		private readonly TagService $tagService,
		private readonly OptionService $optionService,
		private readonly ProductService $productService,
		private readonly CategoryService $categoryService,
	) {
		$this->title = "Products";
	}

	final public function index(): View {
		$this->authorize("access", [Product::class, PermissionEnum::PRODUCT_ACCESS]);
		$content['title'] = $this->title;
		$content['headers'] = ["ID", "Image", "Name", "Price", "Quantity"];
		return view("admin.products.index")->with($content);
	}

	final public function paginate(): JsonResponse {
		$this->authorize("access", [Product::class, PermissionEnum::PRODUCT_ACCESS]);
		return $this->productService->paginate();
	}

	final public function showManage(Product $product = null): View {
		$this->authorize("access", [Product::class, PermissionEnum::PRODUCT_MANAGE]);

		$content["title"] = $this->title;

		$content["tags"] = $this->tagService->getTagsForDropdown();
		$content["categories"] = $this->categoryService->getCategoriesForDropdown();
		$content["relatedProducts"] = $this->productService->getProductsForDropdown();
		$content["productOptions"] = $this->optionService->getOptionsForDropdown();

		$productData = $this->productService->fetchProductDataForManagement($product);

		$content = array_merge($content, $productData);

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
