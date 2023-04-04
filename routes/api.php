<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\QuickCategoryController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\TagController;
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


Route::group(["prefix" => "auth"], static function () {
	Route::post("/sign-in", [AuthController::class, "signIn"]);
	Route::post("/sign-up", [AuthController::class, "signUp"]);
	Route::post("/forgot-password", [AuthController::class, "forgotPassword"]);
	Route::post("/reset-password", [AuthController::class, "resetPassword"]);

	Route::group(["middleware" => "auth:jwt"], static function () {
		Route::post("/sign-out", [AuthController::class, "signOut"]);
		Route::post("/refresh", [AuthController::class, "refresh"]);
		Route::post("/change-password", [AuthController::class, "changePassword"]);
	});
});

Route::group(["prefix" => "category"], static function () {
	Route::get("/", [CategoryController::class, "index"]);
	Route::get("/{category:slug}", [CategoryController::class, "getSingleCategory"]);
	Route::get("/{category:slug}/products", [CategoryController::class, "categoryProducts"]);
});

Route::group(["prefix" => "brand"], static function () {
	Route::get("/", [BrandController::class, "index"]);
	Route::get("/{brand:slug}", [BrandController::class, "getSingleBrand"]);
	Route::get("/{brand:slug}/products", [BrandController::class, "brandProducts"]);
	Route::get("/product/slider", [BrandController::class, "brandWithProducts"]);
});

Route::group(["prefix" => "product"], static function () {
	Route::get("/", [ProductController::class, "index"]);
	Route::get("/{product:slug}", [ProductController::class, "productDetails"]);
});

Route::group(["prefix" => "tag"], static function () {
	Route::get("/{tag:slug}/products", [TagController::class, "tagProducts"]);
});

Route::group(["prefix" => "address", "middleware" => "auth:jwt"], static function () {
	Route::get("/", [AddressController::class, "index"]);
	Route::post("/create", [AddressController::class, "create"]);
	Route::patch("/update/{address:id}", [AddressController::class, "update"]);
	Route::delete("/delete/{address:id}", [AddressController::class, "delete"]);
});

Route::get("/setting", [SettingController::class, "setting"]);
Route::get("/banners/{slug}", [BannerController::class, "index"]);
Route::get("/quick-categories", [QuickCategoryController::class, "index"]);
