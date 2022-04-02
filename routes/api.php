<?php

use Illuminate\Http\Request;

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
//
//Route::middleware('auth:api')->get('/{en}/v0.1/api/get-user', function (Request $request) {
//    return $request->user();
//});

// git token
//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
Route::prefix('/{en}/v0.1/api/')->group(function () {
    //Route::get('get-country-list', 'ApiController@countryList')->name('user.get.single.data');
    Route::post('insert-data', 'ApiController@insertApp')->name('user.root.login');
    Route::get('insert-data', 'ApiController@insertApp')->name('user.root.login');



});