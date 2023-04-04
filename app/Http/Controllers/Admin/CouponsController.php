<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Coupon\MassDestroyCouponRequest;
use App\Http\Requests\Admin\Coupon\StoreCouponRequest;
use App\Http\Requests\Admin\Coupon\UpdateCouponRequest;
use App\Models\Coupon;
use App\Services\CouponService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CouponsController extends Controller
{
	public function __construct(private readonly CouponService $couponService) {
		$this->title = 'Coupons';
	}

	final public function index(): View
	{
		abort_if(Gate::denies(PermissionEnum::COUPON_ACCESS->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$content['title'] = $this->title;
		$content['headers'] = ["ID", "Name", "Code", "Type", "Discount", "Date Start", "Date End"];
		return view("admin.coupons.index")->with($content);
	}

	final public function paginate(): JsonResponse {
		abort_if(Gate::denies(PermissionEnum::COUPON_ACCESS->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		return $this->couponService->paginate();
	}

    /**
     * Show the form for creating a new resource.
     */
	final public function create(): View
	{
		abort_if(Gate::denies(PermissionEnum::COUPON_CREATE->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$content["products"] = $this->couponService->getProductsForDropdown();
		$content["categories"] = $this->couponService->getCategoriesForDropdown();
		$content['title'] = $this->title;
		return view('admin.coupons.form')->with($content);
	}

    /**
     * Store a newly created resource in storage.
     */
	final public function store(StoreCouponRequest $storeCouponRequest): RedirectResponse
	{
		$this->couponService->create($storeCouponRequest);
		return redirect()->route('admin.coupons.index')->withToastSuccess('Coupons Created Successfully!');
	}

    /**
     * Display the specified resource.
     */
	final public function show(Coupon $coupon): JsonResponse {
		$coupon = $this->couponService->fetchCouponWithCategoriesAndProducts($coupon);
		return \response()->json($coupon);
	}

    /**
     * Show the form for editing the specified resource.
     */
	final public function edit(Coupon $coupon)
    {
		abort_if(Gate::denies(PermissionEnum::COUPON_EDIT->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$products = $this->couponService->getProductsForDropdown();
		$categories = $this->couponService->getCategoriesForDropdown();
		$coupon = $this->couponService->fetchCouponWithCategoriesAndProducts($coupon);
		$title = $this->title;
		return view('admin.coupons.form',compact('title','coupon','categories','products'));
    }

    /**
     * Update the specified resource in storage.
     */
	final public function update(UpdateCouponRequest $updateCouponRequest, Coupon $coupon)
    {
		$this->couponService->update($updateCouponRequest, $coupon);
		return redirect()->route('admin.coupons.index')->withUpdatedSuccessToastr("Coupon");
    }

    /**
     * Remove the specified resource from storage.
     */
	final public function destroy(Coupon $coupon): JsonResponse {
		abort_if(Gate::denies(PermissionEnum::COUPON_DELETE->value), Response::HTTP_FORBIDDEN, '403 Forbidden');
		$this->couponService->delete($coupon);
		return \response()->json('Coupon Deleted Successfully!');
	}

	final public function massDestroy(MassDestroyCouponRequest $massDestroyCouponRequest): JsonResponse {
		$this->couponService->deleteMany($massDestroyCouponRequest);
		return \response()->json('Selected records Deleted Successfully.');
	}
}
