<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\test;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

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

Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);
Route::patch('products/{product}/categories/', [ProductController::class, 'deleteFromCategory'])->name('products.deleteFromCategory');

Route::get('carts/{cart:token}/items', [CartController::class, 'index'])->name('cart.index');
Route::post('carts/{cartToken}/items', [CartController::class, 'add_item'])->name('cart.add_item');
Route::put('carts/{cart:token}/items/{cartItem}', [CartController::class, 'update_item'])->name('cart.update_item');
Route::delete('carts/{cart:token}/items/{cartItem}', [CartController::class, 'delete_item'])->name('cart.delete_item');
Route::post('carts/{cart:token}/checkout', [CartController::class, 'checkout'])->name('cart.checkout');



Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'user'])->name('user');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});
