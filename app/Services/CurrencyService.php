<?php

namespace App\Services;

use App\Enums\PermissionEnum;
use App\Http\Requests\Currency\CreateCurrencyRequest;
use App\Http\Requests\Currency\DeleteManyCurrencyRequest;
use App\Http\Requests\Currency\UpdateCurrencyRequest;
use App\Models\Currency;
use App\Services\Datatables\DataTableService;
use Illuminate\Http\JsonResponse;

class CurrencyService {
	public function __construct(private readonly DataTableService $datatable) {}

	final public function paginate(): JsonResponse {
		$model = Currency::class;
		$routeModelName = "currencies";
		$columns = ["id", "name", "symbol", "short_name"];

		return $this->datatable->of($model)
			->withColumns($columns)
			->withSelectionColumn()
			->withEditAction(PermissionEnum::CURRENCY_EDIT)
			->withDeleteAction(PermissionEnum::CURRENCY_DELETE)
			->paginate($routeModelName);
	}

	final public function create(CreateCurrencyRequest $createCurrencyRequest): Currency {
		$data = $createCurrencyRequest->validated();

		return Currency::create($data);
	}

	final public function update(Currency $currency, UpdateCurrencyRequest $updateCurrencyRequest): Currency {
		$data = $updateCurrencyRequest->validated();

		$currency->update($data);

		return $currency;
	}

	final public function deleteMany(DeleteManyCurrencyRequest $deleteManyCurrencyRequest): void {
		$validatedCurrencyIds = $deleteManyCurrencyRequest->validated();

		Currency::whereIn("id", $validatedCurrencyIds["ids"])->delete();
	}

	final public function delete(Currency $currency): void {
		$currency->delete();
	}
}
