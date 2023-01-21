<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Currency\CreateCurrencyRequest;
use App\Http\Requests\Currency\DeleteManyCurrencyRequest;
use App\Http\Requests\Currency\UpdateCurrencyRequest;
use App\Models\Currency;
use App\Services\CurrencyService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CurrencyController extends Controller {
	private readonly string $title;

	public function __construct(private readonly CurrencyService $currencyService) {
		$this->title = "Currencies";
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function index(): View {
		$this->authorize("access", [Currency::class, PermissionEnum::CURRENCY_ACCESS]);

		$content['title'] = $this->title;
		$content['headers'] = ["ID", "Currency Name", "Currency Symbol", "Currency Short Name"];

		return view("admin.currencies.index")->with($content);
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function paginate(): JsonResponse {
		$this->authorize("access", [Currency::class, PermissionEnum::CURRENCY_ACCESS]);

		return $this->currencyService->paginate();
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function store(CreateCurrencyRequest $createCurrencyRequest): RedirectResponse {
		$this->authorize("access", [Currency::class, PermissionEnum::CURRENCY_CREATE]);

		$this->currencyService->create($createCurrencyRequest);

		return redirect()->route("admin.currencies.index")->withCreatedSuccessToastr("Currency");
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function create(): View {
		$this->authorize("access", [Currency::class, PermissionEnum::CURRENCY_CREATE]);

		$content['title'] = $this->title;

		return view("admin.currencies.create")->with($content);
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function edit(Currency $currency): View {
		$this->authorize("access", [Currency::class, PermissionEnum::CURRENCY_EDIT]);

		$content['model'] = $currency;
		$content['title'] = $this->title;

		return view("admin.currencies.edit")->with($content);
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function update(Currency $currency, UpdateCurrencyRequest $updateCurrencyRequest): RedirectResponse {
		$this->authorize("access", [Currency::class, PermissionEnum::CURRENCY_EDIT]);

		$this->currencyService->update($currency, $updateCurrencyRequest);

		return redirect()->route("admin.currencies.index")->withUpdatedSuccessToastr("Currency");
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function deleteMany(DeleteManyCurrencyRequest $deleteManyCurrencyRequest): JsonResponse {
		$this->authorize("access", [Currency::class, PermissionEnum::CURRENCY_DELETE]);

		$this->currencyService->deleteMany($deleteManyCurrencyRequest);
		$content["message"] = "Currencies deleted successfully";

		return response()->json($content);
	}

	/**
	 * @throws AuthorizationException
	 */
	final public function delete(Currency $currency): JsonResponse {
		$this->authorize("access", [Currency::class, PermissionEnum::CURRENCY_DELETE]);

		$this->currencyService->delete($currency);
		$content["message"] = "Currency deleted successfully";

		return response()->json($content);
	}
}
