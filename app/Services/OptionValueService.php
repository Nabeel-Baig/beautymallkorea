<?php

namespace App\Services;

use App\Http\Requests\Admin\Option\CreateOptionRequest;
use App\Http\Requests\Admin\Option\UpdateOptionRequest;
use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class OptionValueService {
	/**
	 * @param Option                                  $option
	 * @param CreateOptionRequest|UpdateOptionRequest $createOrUpdateOptionRequest
	 *
	 * @return void
	 */
	final public function manageOptionValues(Option $option, CreateOptionRequest|UpdateOptionRequest $createOrUpdateOptionRequest): void {
		$optionValuesToCreate = [];
		$optionValuesNotToDeleteIds = [];
		$manageOptionsData = $createOrUpdateOptionRequest->validated();
		$optionValues = $manageOptionsData["option_values"];
		$timestamp = Carbon::now()->toDateTimeString();

		foreach ($optionValues as $optionValue) {
			if (!Arr::exists($optionValue, "image") || $optionValue["image"] === null) {
				$optionValue["image"] = $optionValue["old_image"] ?? null;
			}

			unset($optionValue["old_image"]);

			$optionValue = handleFilesIfPresent("option_values", $optionValue, $optionValue["image"]);

			if (!Arr::exists($optionValue, "id")) {
				$optionValue["option_id"] = $option->id;
				$optionValue["created_at"] = $timestamp;
				$optionValue["updated_at"] = $timestamp;
				$optionValuesToCreate[] = $optionValue;

				continue;
			}

			OptionValue::whereId($optionValue["id"])->update($optionValue);
			$optionValuesNotToDeleteIds[] = $optionValue["id"];
		}

		OptionValue::whereNotIn("id", $optionValuesNotToDeleteIds)->delete();

		OptionValue::insert($optionValuesToCreate);
	}

	final public function loadOptionValues(Option $option): Option {
		$option->load(["optionValues:id,option_id,name,image"]);

		return $option;
	}

	final public function getOptionValuesForDropdown(int $optionId): Collection {
		return OptionValue::whereOptionId($optionId)->select(["id", "name"])->get();
	}
}
