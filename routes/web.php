<?php

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

Route::get('/', 'MainController@pogoda');

Route::prefix('orders')->group(function () {
    Route::get('/', 'OrdersController@catalog');
    Route::get('/{id}', 'OrdersController@view');
    Route::post('/{id}', 'OrdersController@update');
});

Route::prefix('products')->group(function () {
    Route::get('/', 'ProductsController@catalog');
    Route::post('/{id}', 'ProductsController@update');
});
