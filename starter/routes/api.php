<?php

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
Route::group(['prefix' => 'v1'], function () {
    //merchant routes
    Route::group(['prefix' => 'merchants'], function () {
        //jwt routes for merchants
        Route::group([
            'namespace' => '\App\Http\Controllers\Auth\Merchants',
            'prefix'    => 'auth'

        ], function () {
            Route::post('login', 'AuthController@login')->name(
                'merchants_login'
            );
            Route::post('register', 'AuthController@register');
            Route::post('logout', 'AuthController@logout');
            Route::post('refresh', 'AuthController@refresh');
            Route::post('me', 'AuthController@me');
        });
        Route::group(['middleware' => 'auth:merchants'], function () {
        });
    });
    //customers routes
    Route::group(['prefix' => 'customers'], function () {
        //jwt routes for customers
        Route::group([
            'namespace' => '\App\Http\Controllers\Auth\Customers',
            'prefix'    => 'auth'
        ], function () {
            Route::post('login', 'AuthController@login')->name(
                'customers_login'
            );
            Route::post('register', 'AuthController@register');
            Route::post('logout', 'AuthController@logout');
            Route::post('refresh', 'AuthController@refresh');
            Route::post('me', 'AuthController@me');
        });
        Route::group(['middleware' => 'auth:customers'], function () {
            Route::get('test', function () {
                return 'it worked';
            });
        });
    });
});
