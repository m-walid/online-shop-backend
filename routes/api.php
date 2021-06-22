<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
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


// Route::get('/products', [ProductController::class,'index']);
// Route::post('/products', [ProductController::class,'store']);

Route::resource('products',ProductController::class);
Route::get('/products/search/{name}',[ProductController::class,'search']);
Route::get('/products/filterByCategory/{category_id}',[ProductController::class,'filterByCategory']);

Route::resource('categories',CategoryController::class);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
