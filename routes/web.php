<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\PermissionsController;
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
/* Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth', 'twofactor']], function () {
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

    //    Settings
    Route::resource('settings', SettingsController::class)->only(['edit', 'update']);

    // Categories
    Route::delete('categories/destroy', [CategoriesController::class, 'massDestroy'])->name('categories.massDestroy');
    Route::resource('categories', CategoriesController::class);

    // Funds
    Route::delete('funds/destroy', [FundsController::class, 'massDestroy'])->name('funds.massDestroy');
    Route::resource('funds', FundsController::class);

    // Orders
    Route::delete('orders/destroy', [OrdersController::class, 'massDestroy'])->name('orders.massDestroy');
    Route::resource('orders', OrdersController::class);

    // Payments
    Route::delete('payments/destroy', [PaymentsController::class, 'massDestroy'])->name('payments.massDestroy');
    Route::resource('payments', PaymentsController::class);

    // Update User Details
    Route::put('/update-profile/{user}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
    Route::get('/edit-profile', [App\Http\Controllers\HomeController::class, 'editProfile'])->name('editProfile');

    Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
}); */

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

	// Currency
	Route::group(["prefix" => "currencies", "as" => "currencies."], static function () {
		Route::get("/", [CurrencyController::class, "index"])->name("index");
		Route::get("/paginate", [CurrencyController::class, "paginate"])->name("paginate");
		Route::get("/create", [CurrencyController::class, "create"])->name("create");
		Route::post("/store", [CurrencyController::class, "store"])->name("store");
		Route::get("/edit/{currency}", [CurrencyController::class, "edit"])->name("edit");
		Route::patch("/update/{currency}", [CurrencyController::class, "update"])->name("update");
		Route::delete("/delete/{currency}", [CurrencyController::class, "delete"])->name("delete");
		Route::delete("/delete", [CurrencyController::class, "deleteMany"])->name("delete.many");
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
