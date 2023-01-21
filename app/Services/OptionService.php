<?php

namespace App\Services;

use App\Enums\PermissionEnum;
use App\Http\Requests\Option\CreateOptionRequest;
use App\Http\Requests\Option\DeleteManyOptionRequest;
use App\Http\Requests\Option\UpdateOptionRequest;
use App\Models\Currency;
use App\Models\Option;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class OptionService {
	public function __construct() {}

	final public function paginate(): JsonResponse {
		return datatables()->of(Option::orderBy('id', 'desc')->get())
			->addColumn('selection', function ($data) {
				return '<input type="checkbox" class="delete_checkbox flat" value="' . $data['id'] . '">';
			})->addColumn('actions', function ($data) {
				$edit = '';
				$delete = '';
				if (Gate::allows(PermissionEnum::TAG_EDIT->value)) {
					$edit = '<a title="Edit" href="' . route('admin.options.edit', $data->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-pen"></i></a>&nbsp;';
				}
				if (Gate::allows(PermissionEnum::TAG_DELETE->value)) {
					$delete = '<button title="Delete" type="button" name="delete" id="' . $data['id'] . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
				}
				return $edit . $delete;
			})->rawColumns(['selection', 'actions'])->make(true);
	}

	final public function create(CreateOptionRequest $createOptionRequest): Option {
		$optionData = $createOptionRequest->only(["name"]);

		return Option::create($optionData);
	}

	final public function update(Option $option, UpdateOptionRequest $updateOptionRequest): Option {
		$optionData = $updateOptionRequest->only(["name"]);
		$option->update($optionData);

		return $option;
	}

	final public function deleteMany(DeleteManyOptionRequest $deleteManyOptionRequest): void {
		$recordsToDelete = $deleteManyOptionRequest->get("ids");

		Currency::whereIn("id", $recordsToDelete)->delete();
	}

	final public function delete(Option $option): void {
		$option->delete();
	}

}
