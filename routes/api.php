<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group( ['prefix'=>'v1'],function(){

    Route::group( ['prefix'=>'/user','middleware'=>['guest:api'],'namespace'=>'Api' ],function(){
        Route::post('/login','AuthController@login');
        Route::post('/register','AuthController@register');
        Route::post('/forget-password','AuthController@forget');
        Route::post('/forget-token','AuthController@forget_token');
        Route::post('/check-auth','AuthController@check_auth');
    });

    Route::group( ['prefix'=>'/user','middleware'=>['auth:api'],'namespace'=>'Api' ],function(){
        Route::get('/logout','AuthController@logout');
        Route::post('/update-profile','AuthController@update_profile');
        Route::post('/update-profile-pic','AuthController@update_profile_pic');
    });

    Route::group( ['prefix'=>'/book-list','middleware'=>['auth:api']],function(){
        Route::get('/','BookListController@book_list');
        Route::post('/store','BookListController@store');
        Route::post('/update','BookListController@update');
        Route::get('/get/{id}','BookListController@get');
        Route::post('/delete','BookListController@delete');
        Route::post('/delete-multi','BookListController@delete_multi');
    });

});


Route::post('/test-data',function(){
    return request()->all();
});
