<?php
/**
 * Created by PhpStorm.
 * User: backend
 * Date: 5/28/18
 * Time: 2:24 PM
 */
Route::get('/hello/hayat/home', 'FrontController@test');
Route::group(['prefix'=>'/{en}/v0.1/web/'],function () {
    Route::post('registration', 'WebController@signUp')->name('user.signup')->middleware('RouteTokenAccess');
    Route::post('login', 'WebController@logIn')->name('user.logIn')->middleware('RouteTokenAccess');
});