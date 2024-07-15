<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['prefix'=>'v1'],function()
{
    Route::get('products',[\App\Http\Controllers\api\v1\ProductController::class,'index'])->middleware('checker_api');
    Route::post('product/delete',[\App\Http\Controllers\api\v1\ProductController::class,'delete'])->middleware('checker_api');
    Route::post('product/store',[\App\Http\Controllers\api\v1\ProductController::class,'store'])->middleware('checker_api');
    Route::post('product/quantity',[\App\Http\Controllers\api\v1\ProductController::class,'quantity'])->middleware('checker_api');

    Route::get('store/{id}/product/list/update', [\App\Http\Controllers\api\v1\ProductController::class,'listUpdate'])->middleware('checker_api');
    Route::get('store/{id}/product/list/delete', [\App\Http\Controllers\api\v1\ProductController::class,'listDelete'])->middleware('checker_api');
    Route::get('store/{id}/product/list/new', [\App\Http\Controllers\api\v1\ProductController::class,'listNew'])->middleware('checker_api');
    Route::get('store/{id}/product/list/exclude', [\App\Http\Controllers\api\v1\ProductController::class,'listExclude'])->middleware('checker_api');

    Route::post('order/store',[\App\Http\Controllers\api\v1\OrderController::class,'store'])->middleware('checker_api');
 //   Route::get('store/{id}/product/list/update/count', [\App\Http\Controllers\api\v1\ProductController::class,'listUpdateCount'])->middleware('checker_api');
   // Route::get('store/{id}/product/list/delete/count', [\App\Http\Controllers\api\v1\ProductController::class,'listDeleteCount'])->middleware('checker_api');
  //  Route::get('store/{id}/product/list/new/count', [\App\Http\Controllers\api\v1\ProductController::class,'listNewCount'])->middleware('checker_api');
    Route::post('product/callback/{action}',[\App\Http\Controllers\api\v1\ProductController::class,'callback'])->middleware('checker_api');
    Route::get('check/{api}',[\App\Http\Controllers\api\v1\ApiController::class,'check']);
	Route::post('product/exist',[\App\Http\Controllers\api\v1\ProductController::class,'existInDatabase'])
        ->middleware('checker_api');
    Route::post('product/exclude',[\App\Http\Controllers\api\v1\ProductController::class,'exclude'])->middleware('checker_api');
    Route::post('product/status',[\App\Http\Controllers\api\v1\ProductController::class,'status'])->middleware('checker_api');



});
