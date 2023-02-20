<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Option\CreateOptionRequest;
use App\Http\Requests\Admin\Option\DeleteManyOptionRequest;
use App\Http\Requests\Admin\Option\UpdateOptionRequest;
use App\Models\Option;
use App\Services\OptionService;
use App\Services\OptionValueService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OptionController extends Controller {
	private readonly string $title;

	public function __construct(private readonly OptionService $optionService, private readonly OptionValueService $optionValueService) {
		$this->title = "Variants";
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function index(): View {
		$this->authorize("access", [Option::class, PermissionEnum::OPTION_ACCESS]);

		$content['title'] = $this->title;
		$content['headers'] = ["ID", "Variant Name"];

		return view("admin.options.index")->with($content);
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function paginate(): JsonResponse {
		$this->authorize("access", [Option::class, PermissionEnum::OPTION_ACCESS]);

		return $this->optionService->paginate();
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function store(CreateOptionRequest $createOptionRequest): RedirectResponse {
		$this->authorize("access", [Option::class, PermissionEnum::OPTION_CREATE]);

		DB::transaction(function () use ($createOptionRequest) {
			$option = $this->optionService->create($createOptionRequest);
			$this->optionValueService->manageOptionValues($option, $createOptionRequest);
		});

		return redirect()->route("admin.options.index")->withCreatedSuccessToastr("Option");
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function create(): View {
		$this->authorize("access", [Option::class, PermissionEnum::OPTION_CREATE]);

		$content['title'] = $this->title;

		return view("admin.options.create")->with($content);
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function edit(Option $option): View {
		$this->authorize("access", [Option::class, PermissionEnum::OPTION_EDIT]);

		$option = $this->optionValueService->loadOptionValues($option);

		$content['title'] = $this->title;
		$content['model'] = $option;

		return view("admin.options.edit")->with($content);
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function update(Option $option, UpdateOptionRequest $updateOptionRequest): RedirectResponse {
		$this->authorize("access", [Option::class, PermissionEnum::OPTION_EDIT]);

		DB::transaction(function () use ($option, $updateOptionRequest) {
			$option = $this->optionService->update($option, $updateOptionRequest);
			$this->optionValueService->manageOptionValues($option, $updateOptionRequest);
		});

		return redirect()->route("admin.options.index")->withUpdatedSuccessToastr("Option");
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function deleteMany(DeleteManyOptionRequest $deleteManyOptionRequest): JsonResponse {
		$this->authorize("access", [Option::class, PermissionEnum::OPTION_DELETE]);

		$this->optionService->deleteMany($deleteManyOptionRequest);
		$content["message"] = "Tags deleted successfully";

		return response()->json($content);
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function delete(Option $option): JsonResponse {
		$this->authorize("access", [Option::class, PermissionEnum::OPTION_DELETE]);

		$this->optionService->delete($option);
		$content["message"] = "Option deleted successfully";

		return response()->json($content);
	}
}
