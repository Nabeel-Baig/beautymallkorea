<?php

use App\Http\Controllers\Api\AuthController;
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
	Route::get('/users',function () {
		return response()->json([
			'users' => \App\Models\User::all()
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
Route::post('/register',[AuthController::class,'register']);
Route::get('/categories',[\App\Http\Controllers\Api\CategoryController::class,'index']);
Route::get('/setting',[\App\Http\Controllers\Api\GeneralController::class,'setting']);
Route::get('/greeting', function () {
	return response()->json('Hello World');
});
