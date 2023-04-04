<?php

namespace App\Services;

use App\Enums\PermissionEnum;
use App\Http\Requests\Admin\Coupon\MassDestroyCouponRequest;
use App\Http\Requests\Admin\Coupon\StoreCouponRequest;
use App\Http\Requests\Admin\Coupon\UpdateCouponRequest;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\JsonResponse;

class CouponService
{
	public function __construct() {}

	final public function paginate(): JsonResponse
	{
		return datatables()->of(Coupon::orderBy('id', 'desc')->get())
			->addColumn('selection', function ($data) {
				return '<input type="checkbox" class="delete_checkbox flat" value="' . $data['id'] . '">';
			})->addColumn('actions', function ($data) {
				$edit = '';
				$delete = '';
				$view  = '';
				if (Gate::allows(PermissionEnum::COUPON_EDIT->value)) {
					$edit = '<a title="Edit" href="' . route('admin.coupons.edit', $data->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-pen"></i></a>&nbsp;';
				}
				if (Gate::allows(PermissionEnum::COUPON_SHOW->value)) {
					$view = '<button title="View" type="button" name="view" id="' . $data['id'] . '" class="view btn btn-info btn-sm"><i class="fa fa-eye"></i></button>&nbsp;';
				}
				if (Gate::allows(PermissionEnum::COUPON_DELETE->value)) {
					$delete = '<button title="Delete" type="button" name="delete" id="' . $data['id'] . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
				}
				return $edit . $view . $delete;
			})->rawColumns(['selection', 'actions'])->make(true);
	}

	final public function getProductsForDropdown(): Collection {
		return Product::latest('id')->get()->pluck('name','id');
	}

	final public function getCategoriesForDropdown(): Collection {
		return Category::latest('id')->get()->pluck('name','id');
	}

	final public function create(StoreCouponRequest $storeCouponRequest): Coupon {
		$coupon = Coupon::create(handleFiles('coupons', $storeCouponRequest->validated()));
		$coupon->categories()->sync($storeCouponRequest->input('categories',[]));
		$coupon->products()->sync($storeCouponRequest->input('products',[]));
		return $coupon;
	}

	final public function fetchCouponWithCategoriesAndProducts(Coupon $coupon): Coupon
	{
		$coupon->load([
			'categories' => static function (BelongsToMany $category) {
			return $category->select(['categories.id','categories.name']);
			},
			'products' => static function (BelongsToMany $product) {
			return $product->select(['products.id','products.name']);
			}
		]);
		return $coupon;
	}

	final public function update(UpdateCouponRequest $updateCouponRequest, Coupon $coupon): Coupon {
		$data = handleFilesIfPresent('coupons', $updateCouponRequest->validated(), $coupon);
		$coupon->update($data);
		$coupon->categories()->sync($updateCouponRequest->input('categories',[]));
		$coupon->products()->sync($updateCouponRequest->input('products',[]));;
		return $coupon;
	}

	final public function deleteMany(MassDestroyCouponRequest $massDestroyCouponRequest): void {
		$recordsToDelete = $massDestroyCouponRequest->get("ids");

		Coupon::whereIn("id", $recordsToDelete)->delete();
	}

	final public function delete(Coupon $coupon): void {
		$coupon->delete();
	}
}
