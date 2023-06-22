<?php

namespace App\Services\Api;

use App\Http\Requests\Api\Wishlist\CreateWishlistRequest;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Symfony\Component\HttpFoundation\Response;

class WishlistApiService {
	final public function __construct(private readonly AuthApiService $authApiService) {}

	final public function index(): Collection
	{
		$customer = $this->authApiService->getAuthenticatedCustomer();

		$optionInclusion = static fn (BelongsTo $option) => $option->select(["id", "name"]);
		$optionValueInclusion = static fn (BelongsTo $optionValue) => $optionValue->select(["id", "option_id", "name", "image"])->with(["option" => $optionInclusion]);
		$productOptionInclusion = static fn (BelongsTo $productOption) => $productOption->select(["id", "option_value_id"])->with(["optionValue" => $optionValueInclusion]);
		$productInclusion = static fn (BelongsTo $product) => $product->select(["id", "name", "description", "image"]);

		return Wishlist::with(["product" => $productInclusion, "productOption" => $productOptionInclusion])->whereCustomerId($customer->id)->get();
	}

	final public function create(CreateWishlistRequest $createWishlistRequest): Wishlist {
		$data = $createWishlistRequest->validated();
		$customer = $this->authApiService->getAuthenticatedCustomer();

		$itemToAddInCart = $createWishlistRequest->input("product_option_id") !== null
			? ProductOption::whereId($data["product_option_id"])->whereProductId($data["product_id"])->select(["id", "product_id"])->firstOrFail()
			: Product::whereId($data["product_id"])->select(["id"])->firstOrFail();

		return $itemToAddInCart instanceof ProductOption
			? Wishlist::create([
				"customer_id" => $customer->id,
				"product_id" => $itemToAddInCart->product_id,
				"product_option_id" => $itemToAddInCart->id,
			])
			: Wishlist::create([
				"customer_id" => $customer->id,
				"product_id" => $itemToAddInCart->id,
			]);
	}

	final public function delete(Wishlist $wishlist): bool {
		$customer = $this->authApiService->getAuthenticatedCustomer();

		if ($wishlist->customer_id !== $customer->id) {
			abort(Response::HTTP_NOT_FOUND, "Wishlist item not found!");
		}

		return $wishlist->delete();
	}
}
