<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Wishlist\CreateWishlistRequest;
use App\Http\Resources\Api\Wishlist\WishlistListCollection;
use App\Http\Resources\Api\Wishlist\WishlistResource;
use App\Models\Wishlist;
use App\Services\Api\WishlistApiService;
use Illuminate\Http\JsonResponse;

class WishlistController extends Controller {
	final public function __construct(private readonly WishlistApiService $wishlistApiService) {}

	final public function index(): WishlistListCollection {
		$wishlist = $this->wishlistApiService->index();

		return new WishlistListCollection($wishlist);
	}

	final public function create(CreateWishlistRequest $createWishlistRequest): WishlistResource {
		$wishlist = $this->wishlistApiService->create($createWishlistRequest);

		return new WishlistResource($wishlist);
	}

	final public function delete(Wishlist $wishlist): JsonResponse {
		$deleted = $this->wishlistApiService->delete($wishlist);

		return response()->json(["data" => $deleted]);
	}
}
