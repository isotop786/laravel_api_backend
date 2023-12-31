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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('users','UserController@index')->name('users');
// Route::get('users/{id}', 'UserController@show');
// Route::post('users','UserController@store');
// Route::put('users/{id}','UserController@update');
// Route::delete('users/{id}','UserController@destroy');

Route::post('login','AuthController@login')->name('login');
Route::post('register','AuthController@register')->name('register');

Route::group(['middleware' => ['auth:api','cors']], function(){
    Route::get('user','UserController@user');
    Route::put('users/info','UserController@updateInfo');
    Route::get('users/password','UserController@updatePassword');
    Route::post('upload','ImageController@upload');


    Route::apiResource('users','UserController');
    Route::apiResource('roles','RoleController');
    Route::apiResource('categories','CategoryController');
    Route::apiResource('products','ProductController');
});