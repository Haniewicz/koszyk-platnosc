<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\test;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartItemController;

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

Route::get('test', [test::class, 'index']);

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');


Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'user'])->name('user');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class);
    Route::patch('products/{product}/categories/', [ProductController::class, 'deleteFromCategory'])->name('products.deleteFromCategory');
    Route::apiResource('cart_items', CartItemController::class)->middleware('cart_exists');
});
