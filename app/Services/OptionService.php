<?php

namespace App\Services;

use App\Enums\PermissionEnum;
use App\Http\Requests\Admin\Option\CreateOptionRequest;
use App\Http\Requests\Admin\Option\DeleteManyOptionRequest;
use App\Http\Requests\Admin\Option\UpdateOptionRequest;
use App\Models\Option;
use App\Services\Datatables\DataTableService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class OptionService {
	public function __construct(private readonly DataTableService $dataTableService) {}

	final public function paginate(): JsonResponse {
		$model = Option::class;
		$routeModelName = "options";
		$columns = ["id", "name"];

		return $this->dataTableService->of($model)
			->withColumns($columns)
			->withSelectionColumn()
			->withEditAction(PermissionEnum::OPTION_EDIT)
			->withDeleteAction(PermissionEnum::OPTION_DELETE)
			->paginate($routeModelName);
	}

	final public function getOptionsForDropdown(): Collection {
		return Option::select(["id", "name"])->get();
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

		Option::whereIn("id", $recordsToDelete)->delete();
	}

	final public function delete(Option $option): void {
		$option->delete();
	}

}
