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
    });

    Route::group( ['prefix'=>'/user','middleware'=>['auth:api'],'namespace'=>'Api' ],function(){
        Route::get('/check-auth','AuthController@check_auth');
        Route::get('/users','AuthController@users');
        Route::get('/logout','AuthController@logout');
        Route::post('/update-profile','AuthController@update_profile');
        Route::post('/update-profile-pic','AuthController@update_profile_pic');
    });

    Route::group( ['prefix'=>'/inventory','middleware'=>['auth:api'],'namespace'=>'Inventory' ],function(){
        Route::group( ['prefix'=>'category'],function(){
            Route::get('/all','DrugCategoryController@all');
            Route::get('/get/{category}','DrugCategoryController@get');
            Route::post('/create','DrugCategoryController@create');
            Route::post('/update','DrugCategoryController@update');
            Route::post('/delete','DrugCategoryController@delete');
        });

        Route::group( ['prefix'=>'storage'],function(){
            Route::get('/all','DrugStorageController@all');
            Route::get('/get/{category}','DrugStorageController@get');
            Route::post('/create','DrugStorageController@create');
            Route::post('/update','DrugStorageController@update');
            Route::post('/delete','DrugStorageController@delete');
        });

        Route::group( ['prefix'=>'manufacturer'],function(){
            Route::get('/all','DrugManufacturerController@all');
            Route::get('/get/{category}','DrugManufacturerController@get');
            Route::post('/create','DrugManufacturerController@create');
            Route::post('/update','DrugManufacturerController@update');
            Route::post('/delete','DrugManufacturerController@delete');
        });

        Route::group( ['prefix'=>'supplier'],function(){
            Route::get('/all','DrugSupplierController@all');
            Route::get('/get/{category}','DrugSupplierController@get');
            Route::post('/create','DrugSupplierController@create');
            Route::post('/update','DrugSupplierController@update');
            Route::post('/delete','DrugSupplierController@delete');
        });

        Route::group( ['prefix'=>'drug'],function(){
            Route::get('/all','DrugController@all');
            Route::get('/get/{category}','DrugController@get');
            Route::post('/create','DrugController@create');
            Route::post('/update','DrugController@update');
            Route::post('/delete','DrugController@delete');
        });
    });


    Route::group( ['prefix'=>'/consumer','middleware'=>['auth:api'],'namespace'=>'Consumer' ],function(){
        Route::get('/test','ConsumerController@get_data');
    });

});


Route::post('/v1/test-data',function(){
    return request()->all();
});
Route::get('/get',function(){
    return 'ok';
});

