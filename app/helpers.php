<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

if (!function_exists("handleFiles")) {
	/**
	 * @param string                    $cmsPage
	 * @param Array<UploadedFile|mixed> $inputData
	 *
	 * @return array
	 */
	function handleFiles(string $cmsPage, array $inputData): array {
		foreach ($inputData as $index => $inputDatum) {
			if ($inputDatum === null) {
				continue;
			}

			if (is_array($inputDatum)) {
				$inputData[$index] = handleFiles($cmsPage, $inputDatum);

				continue;
			}

			if ($inputDatum instanceof UploadedFile) {
				$fileName = "/assets/uploads/$cmsPage/{$inputDatum->hashName()}";
				$inputData[$index] = $fileName;
				$inputDatum->move(
					public_path("assets/uploads/$cmsPage"), $fileName,
				);
			}
		}
		return $inputData;
	}
}

if (!function_exists("handleFilesIfPresent")) {
	/**
	 * @param string                    $cmsPage
	 * @param Array<UploadedFile|mixed> $inputData
	 * @param Model|string|null         $model
	 *
	 * @return array
	 */
	function handleFilesIfPresent(string $cmsPage, array $inputData, Model|string|null $model): array {
		foreach ($inputData as $index => $inputDatum) {
			if ($inputDatum === null) {
				continue;
			}

			if (is_array($inputDatum)) {
				$inputData[$index] = handleFilesIfPresent($cmsPage, $inputDatum, $model);

				continue;
			}

			if ($inputDatum instanceof UploadedFile) {
				$fileName = "/assets/uploads/$cmsPage/{$inputDatum->hashName()}";
				$inputData[$index] = $fileName;

				if ($model instanceof Model) {
					$model = public_path($model->$index);
				}

				if ($model !== null && File::exists($model)) {
					File::delete($model);
				}

				$inputDatum->move(
					public_path("assets/uploads/$cmsPage"), $fileName,
				);
			}
		}
		return $inputData;
	}
}

if (!function_exists("getPercentage")) {
	function getPercentage(float $part = null, float $whole = null): int {
		return ($part / $whole) * 100;
	}
}

