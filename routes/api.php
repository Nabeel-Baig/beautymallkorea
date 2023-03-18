<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\ProductController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware' => ['auth:sanctum']], function () {
	Route::get('/users', function () {
		return response()->json([
			'users' => User::all(),
		]);
	});
	/* Route::post('/products', [ProductController::class, 'store']);
	Route::put('/products/{id}', [ProductController::class, 'update']);
	Route::delete('/products/{id}', [ProductController::class, 'destroy']); */
	Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
	return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/setting', [GeneralController::class, 'setting']);
Route::get('/greeting', static function () {
	return response()->json('Hello World');
});

Route::get('/banners/{slug}', [BannerController::class, 'index']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/category/{category:slug}', [CategoryController::class, 'categoryProducts']);

Route::get("/brands", [BrandController::class, "index"]);
Route::get('/get-single-brand/{slug}',[BrandController::class,"getSingleBrand"]);
Route::get("/brand/{brand:slug}", [BrandController::class, "brandProducts"]);
Route::get("/brand-with-products/", [BrandController::class, "brandWithProducts"]);

Route::get("/products", [ProductController::class, "index"]);
Route::get("/product/{product:slug}", [ProductController::class, "productDetails"]);
