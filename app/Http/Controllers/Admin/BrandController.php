<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Brand\CreateBrandRequest;
use App\Http\Requests\Admin\Brand\DeleteManyBrandRequest;
use App\Http\Requests\Admin\Brand\UpdateBrandRequest;
use App\Json\CountryJson;
use App\Models\Brand;
use App\Services\BrandService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BrandController extends Controller {
	private readonly string $title;

	public function __construct(private readonly BrandService $brandService, private readonly CountryJson $countryJson) {
		$this->title = "Brands";
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function index(): View {
		$this->authorize("access", [Brand::class, PermissionEnum::BRAND_ACCESS]);

		$content["title"] = $this->title;
		$content["headers"] = ["ID", "Name", "Image", "Banner Image", "Country"];

		return view("admin.brands.index")->with($content);
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function paginate(): JsonResponse {
		$this->authorize("access", [Brand::class, PermissionEnum::BRAND_ACCESS]);

		return $this->brandService->paginate();
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function create(): View {
		$this->authorize("access", [Brand::class, PermissionEnum::BRAND_CREATE]);

		$content["title"] = $this->title;
		$content["countries"] = $this->countryJson->getCountries();

		return view("admin.brands.create")->with($content);
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function store(CreateBrandRequest $createBrandRequest): RedirectResponse {
		$this->authorize("access", [Brand::class, PermissionEnum::BRAND_CREATE]);

		$this->brandService->create($createBrandRequest);

		return redirect()->route("admin.brands.index")->withCreatedSuccessToastr("Brand");
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function edit(Brand $brand): View {
		$this->authorize("access", [Brand::class, PermissionEnum::BRAND_EDIT]);

		$content["title"] = $this->title;
		$content["countries"] = $this->countryJson->getCountries();
		$content["model"] = $brand;

		return view("admin.brands.edit")->with($content);
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function update(Brand $brand, UpdateBrandRequest $updateBrandRequest): RedirectResponse {
		$this->authorize("access", [Brand::class, PermissionEnum::BRAND_EDIT]);

		$this->brandService->update($brand, $updateBrandRequest);

		return redirect()->route("admin.brands.index")->withUpdatedSuccessToastr("Brand");
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function delete(Brand $brand): JsonResponse {
		$this->authorize("access", [Brand::class, PermissionEnum::BRAND_DELETE]);

		$this->brandService->delete($brand);

		return response()->json(["message" => "Brand deleted successfully"]);
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function deleteMany(DeleteManyBrandRequest $deleteManyBrandRequest): JsonResponse {
		$this->authorize("access", [Brand::class, PermissionEnum::BRAND_DELETE]);

		$this->brandService->deleteMany($deleteManyBrandRequest);

		return response()->json(["message" => "Brands deleted Successfully"]);
	}
}
