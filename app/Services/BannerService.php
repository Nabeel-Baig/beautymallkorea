<?php

namespace App\Services;

use App\Enums\PermissionEnum;
use App\Http\Requests\Banner\MassDestroyBannerRequest;
use App\Http\Requests\Banner\ManageBannerRequest;
use App\Models\Banner;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;

class BannerService {
	public function __construct() {}

	final public function paginate(): JsonResponse {
		return datatables()->of(Banner::orderBy('id', 'desc')->get())
			->addColumn('selection', function ($data) {
				return '<input type="checkbox" class="delete_checkbox flat" value="' . $data['id'] . '">';
			})->addColumn('image', function ($data) {
				return '<img width="65" src="' . asset($data->image) . '">';
			})->addColumn('actions', function ($data) {
				$edit = '';
				$delete = '';
				if (Gate::allows(PermissionEnum::BANNER_EDIT->value)) {
					$edit = '<a title="Edit" href="' . route('admin.banners.edit', $data->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-pen"></i></a>&nbsp;';
				}
				if (Gate::allows(PermissionEnum::BANNER_DELETE->value)) {
					$delete = '<button title="Delete" type="button" name="delete" id="' . $data['id'] . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
				}
				return $edit . $delete;
			})->rawColumns(['selection', 'actions','image'])->make(true);
	}

	final public function getOptionsForDropdown(): Collection {
		return Banner::select(["id", "name"])->get();
	}

	final public function create(CreateOptionRequest $createOptionRequest): Option {
		$optionData = $createOptionRequest->only(["name"]);

		return Banner::create($optionData);
	}

	final public function update(Option $option, UpdateOptionRequest $updateOptionRequest): Option {
		$optionData = $updateOptionRequest->only(["name"]);
		$option->update($optionData);

		return $option;
	}

	final public function deleteMany(DeleteManyOptionRequest $deleteManyOptionRequest): void {
		$recordsToDelete = $deleteManyOptionRequest->get("ids");

		Banner::whereIn("id", $recordsToDelete)->delete();
	}

	final public function delete(Option $option): void {
		$option->delete();
	}

}
