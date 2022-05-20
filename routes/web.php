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
Route::get('/', function () {
    return view('login');
})->name('login.home');

Route::post('web-sign-up','signUpController@webUserSignp');
Route::post('{en}/login','WebController@login');


Route::group(['middleware' => ['web']], function () {
    Route::get('{en}/get-call-data/{list_status}','WebController@getCallData')->name('get_call_data');
    Route::get('{en}/helpdesk-numbers','WebController@getNumbersData')->name('get_numbers');
    Route::get('{en}/new-number','WebController@FormInsertNewNumber')->name('form_insert_new_number');
    Route::post('{en}/new-number','WebController@insertNewNumber')->name('insert_new_number');
    Route::get('{en}/update-status','WebController@updateStatus');
    Route::get('{en}/logout','WebController@logout');


});

