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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('makanan', 'api\MenuController@getMakanan');

Route::get('pesanan', 'api\OrderController@getPesananByMeja');

// Route::get('tolakPesanan', 'api\OrderController@tolakPesanan');

Route::get('minuman', 'api\MenuController@getMinuman');

Route::post('lockMeja', 'api\LockController@lockMeja');

Route::post('addOrders', 'api\OrderController@addOrder');

Route::post('checkout', 'api\OrderController@checkoutPesanan');

