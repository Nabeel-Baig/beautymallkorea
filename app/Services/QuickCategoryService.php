<?php

namespace App\Services;

use App\Enums\PermissionEnum;
use App\Http\Requests\Admin\QuickCategory\MassDestroyQuickCategoryRequest;
use App\Http\Requests\Admin\QuickCategory\StoreQuickCategoryRequest;
use App\Http\Requests\Admin\QuickCategory\UpdateQuickCategoryRequest;
use App\Models\Quickcategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class QuickCategoryService
{
	public function __construct() {}

	final public function paginate(): JsonResponse {
		return datatables()->of(Quickcategory::orderBy('id', 'desc')->get())
			->addColumn('selection', function ($data) {
				return '<input type="checkbox" class="delete_checkbox flat" value="' . $data['id'] . '">';
			})->addColumn('image', function ($data) {
				return '<img width="65" src="' . asset($data->image) . '">';
			})->addColumn('actions', function ($data) {
				$edit = '';
				$delete = '';
				if (Gate::allows(PermissionEnum::QUICK_CATEGORY_EDIT->value)) {
					$edit = '<a title="Edit" href="' . route('admin.quickcategories.edit', $data->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-pen"></i></a>&nbsp;';
				}
				if (Gate::allows(PermissionEnum::QUICK_CATEGORY_DELETE->value)) {
					$delete = '<button title="Delete" type="button" name="delete" id="' . $data['id'] . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
				}
				return $edit . $delete;
			})->rawColumns(['selection', 'actions', 'image'])->make(true);
	}

	final public function create(StoreQuickCategoryRequest $storeQuickCategoryRequest): Quickcategory {
		return Quickcategory::create(handleFiles('quickcategories', $storeQuickCategoryRequest->validated()));
	}

	final public function update(UpdateQuickCategoryRequest $updateQuickCategoryRequest, Quickcategory $quickCategory): Quickcategory {
		$data = handleFilesIfPresent('quickcategories', $updateQuickCategoryRequest->validated(), $quickCategory);
		$quickCategory->update($data);
		return $quickCategory;
	}

	final public function deleteMany(MassDestroyQuickCategoryRequest $massDestroyQuickCategoryRequest): void {
		$recordsToDelete = $massDestroyQuickCategoryRequest->get("ids");

		Quickcategory::whereIn("id", $recordsToDelete)->delete();
	}

	final public function delete(Quickcategory $quickCategory): void {
		$quickCategory->delete();
	}
}
