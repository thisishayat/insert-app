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
Auth::routes();
Route::get('/registration', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('web-sign-up','signUpController@webUserSignp');
Route::post('{en}/login','WebController@login');


Route::group(['middleware' => ['web']], function () {
    Route::get('{en}/get-call-data','WebController@getCallData');
    Route::get('{en}/update-status','WebController@updateStatus');

});

