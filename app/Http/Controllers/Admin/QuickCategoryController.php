<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\QuickCategory\MassDestroyQuickCategoryRequest;
use App\Http\Requests\Admin\QuickCategory\StoreQuickCategoryRequest;
use App\Http\Requests\Admin\QuickCategory\UpdateQuickCategoryRequest;
use App\Models\Quickcategory;
use App\Services\QuickCategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class QuickCategoryController extends Controller
{
	public function __construct(private readonly QuickCategoryService $quickCategoryService) {
		$this->title = 'Quick Categories';
	}

	final public function index(): View
	{
		abort_if(Gate::denies(PermissionEnum::QUICK_CATEGORY_ACCESS->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$content['title'] = $this->title;
		$content['headers'] = ["ID", "Name", "Image", "Link", "Sort Order"];
		return view("admin.quickcategories.index")->with($content);
	}

	final public function paginate(): JsonResponse {
		abort_if(Gate::denies(PermissionEnum::QUICK_CATEGORY_ACCESS->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		return $this->quickCategoryService->paginate();
	}

	final public function create(): View
	{
		abort_if(Gate::denies(PermissionEnum::QUICK_CATEGORY_CREATE->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$content['title'] = $this->title;
		return view('admin.quickcategories.form')->with($content);
	}

	final public function store(StoreQuickCategoryRequest $storeQuickCategoryRequest): RedirectResponse
	{
		abort_if(Gate::denies(PermissionEnum::QUICK_CATEGORY_CREATE->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$this->quickCategoryService->create($storeQuickCategoryRequest);
		return redirect()->route('admin.quickcategories.index')->withToastSuccess('Quick Category Created Successfully!');
	}
	public function show($id)
	{
		//
	}

	public function edit(Quickcategory $quickcategory): View
	{
		abort_if(Gate::denies(PermissionEnum::QUICK_CATEGORY_EDIT->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$title = $this->title;
		return view('admin.quickcategories.form',compact('title','quickcategory'));
	}

	public function update(UpdateQuickCategoryRequest $updateQuickCategoryRequest, Quickcategory $quickcategory)
	{
		abort_if(Gate::denies(PermissionEnum::QUICK_CATEGORY_EDIT->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$this->quickCategoryService->update($updateQuickCategoryRequest, $quickcategory);
		return redirect()->route('admin.quickcategories.index')->withUpdatedSuccessToastr("Quick Category");
	}

	public function destroy(Quickcategory $quickcategory): JsonResponse
	{
		abort_if(Gate::denies(PermissionEnum::QUICK_CATEGORY_DELETE->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$this->quickCategoryService->delete($quickcategory);
		return \response()->json('Quick Category Deleted Successfully!');

	}

	final public function massDestroy(MassDestroyQuickCategoryRequest $massDestroyQuickCategoryRequest): JsonResponse {
		abort_if(Gate::denies(PermissionEnum::QUICK_CATEGORY_EDIT->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$this->quickCategoryService->deleteMany($massDestroyQuickCategoryRequest);
		return \response()->json('Selected records Deleted Successfully.');
	}
}
