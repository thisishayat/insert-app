<?php
/**
 * Created by PhpStorm.
 * User: backend
 * Date: 2/19/18
 * Time: 1:03 PM
 */

Route::post('sign-up','signUpController@userSignp')->middleware('RouteTokenAccess');
Route::post('web-sign-up-verify-email','signUpController@webUserSignpVerfiy')->middleware('RouteTokenAccess');
Route::post('mobile-sign-up-code-verification', 'signUpController@mobileCodeSignUpCodeVerify');
Route::post('device-no-verification', 'signUpController@deviceNoVerify');
Route::post('wrong-mobile-number', 'signUpController@wrongMobileNumber');
Route::post('get-token-via-code', 'signUpController@getTokenViaCode');
Route::get('get-country-list', 'ApiController@countryList')->name('user.get.single.data');

