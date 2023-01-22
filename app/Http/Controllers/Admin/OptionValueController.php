<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OptionValueService;
use Illuminate\Http\JsonResponse;

class OptionValueController extends Controller {
	public function __construct(private readonly OptionValueService $optionValueService) {}

	final public function getOptionValuesFromOption(int $optionId): JsonResponse {
		$optionValues = $this->optionValueService->getOptionValuesForDropdown($optionId);

		return response()->json(compact("optionValues"));
	}
}
