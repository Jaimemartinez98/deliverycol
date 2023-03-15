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

Route::post('register', 'App\Http\Controllers\UserController@register');
Route::post('login', 'App\Http\Controllers\UserController@authenticate');



Route::group(['middleware' => ['jwt.verify']], function() {

    Route::post('user','App\Http\Controllers\UserController@getAuthenticatedUser');

    Route::prefix('products')->group(function () {
        Route::get('/index', 'App\Http\Controllers\ProductsController@index');
        Route::post('/store','App\Http\Controllers\ProductsController@store');
        Route::get('/show/{id}', 'App\Http\Controllers\ProductsController@show');
        Route::post('/update','App\Http\Controllers\ProductsController@update');
        Route::post('/delete','App\Http\Controllers\ProductsController@delete');
    });  

    Route::prefix('orders')->group(function () {
        Route::post('/create','App\Http\Controllers\UserOrdersController@createOrder');
        Route::get('/show/{id}', 'App\Http\Controllers\UserOrdersController@showOrder');
        Route::post('/status','App\Http\Controllers\UserOrdersController@changeStatus');
        Route::get('/restaurant', 'App\Http\Controllers\UserOrdersController@getOrdersByRestaurant');
        Route::get('/user', 'App\Http\Controllers\UserOrdersController@getOrdersByUser');
    });  

    Route::prefix('restaurants')->group(function () {
        Route::get('/index', 'App\Http\Controllers\RestaurantsController@index');
        Route::get('/show/{id}', 'App\Http\Controllers\RestaurantsController@show');
    });   

});

