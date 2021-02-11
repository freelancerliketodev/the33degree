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
Route::post('login', 'JwtAuthController@login');
Route::post('register', 'JwtAuthController@register');

Route::group(['middleware' => 'auth.jwt'], function () {

    Route::get('logout', 'JwtAuthController@logout');
    Route::get('user-info', 'JwtAuthController@getUser');
});