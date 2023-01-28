<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\OptionValueController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get("/", static function () {
	return redirect()->route("admin.dashboard");
});

Route::group([
	'prefix' => 'admin',
	'as' => 'admin.',
	'namespace' => 'App\Http\Controllers\Admin',
	'middleware' => ['auth', 'twofactor'],
], static function () {
	Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
	// Permissions
	Route::delete('permissions/destroy', [PermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
	Route::resource('permissions', PermissionsController::class);

	// Roles
	Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.massDestroy');
	Route::resource('roles', RolesController::class);

	// Users
	Route::delete('users/destroy', [UsersController::class, 'massDestroy'])->name('users.massDestroy');
	Route::resource('users', UsersController::class);

	// Categories
	Route::delete('categories/destroy', [CategoriesController::class, 'massDestroy'])->name('categories.massDestroy');
	Route::resource('categories', CategoriesController::class);

	// Tags
	Route::group(["prefix" => "tags", "as" => "tags."], static function () {
		Route::get("/", [TagController::class, "index"])->name("index");
		Route::get("/paginate", [TagController::class, "paginate"])->name("paginate");
		Route::get("/create", [TagController::class, "create"])->name("create");
		Route::post("/store", [TagController::class, "store"])->name("store");
		Route::get("/edit/{tag}", [TagController::class, "edit"])->name("edit");
		Route::patch("/update/{tag}", [TagController::class, "update"])->name("update");
		Route::delete("/delete/{tag}", [TagController::class, "delete"])->name("delete");
		Route::delete("/delete", [TagController::class, "deleteMany"])->name("delete.many");
	});

	// Option
	Route::group(["prefix" => "options", "as" => "options."], static function () {
		Route::get("/", [OptionController::class, "index"])->name("index");
		Route::get("/paginate", [OptionController::class, "paginate"])->name("paginate");
		Route::get("/create", [OptionController::class, "create"])->name("create");
		Route::post("/store", [OptionController::class, "store"])->name("store");
		Route::get("/edit/{option}", [OptionController::class, "edit"])->name("edit");
		Route::patch("/update/{option}", [OptionController::class, "update"])->name("update");
		Route::delete("/delete/{option}", [OptionController::class, "delete"])->name("delete");
		Route::delete("/delete", [OptionController::class, "deleteMany"])->name("delete.many");
	});

	// Option Values
	Route::group(["prefix" => "option-values", "as" => "option-values."], static function () {
		Route::get("/{optionId}", [OptionValueController::class, "getOptionValuesFromOption"])->name("index.dropdown");
	});

	// Products
	Route::group(["prefix" => "products", "as" => "products."], static function () {
		Route::get("/", [ProductController::class, "index"])->name("index");
		Route::get("/paginate", [ProductController::class, "paginate"])->name("paginate");
		Route::get("/manage/{product?}", [ProductController::class, "showManage"])->name("manage.show");
		Route::patch("/manage/{product?}", [ProductController::class, "manage"])->name("manage.update");
		Route::get("/view/{product}", [ProductController::class, "view"])->name("manage.view");
		Route::delete("/delete/{product}", [ProductController::class, "delete"])->name("delete");
		Route::delete("/delete", [ProductController::class, "deleteMany"])->name("delete.many");
	});

	// Settings
	Route::resource('settings', SettingsController::class)->only(['edit', 'update']);
});

// Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

// Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

// Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
