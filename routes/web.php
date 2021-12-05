<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/test','A')->name('route name');

Route::get('/login', function () {
    return response()->json([
        'auth' => 0,
        'message' => 'unathorized',
    ], 401);
})->name('login');

Route::get('/drug-list', 'Inventory\DrugController@drug_list');


Route::get('/test_data_api', function () {
    // $response = Http::get('https://openlibrary.org/search.json?q=web');
    // dd($response->json()['docs']);
    // dd(Hash::make('ok@2009'));
});

Route::get('/data-reload', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate:refresh', ['--seed' => true]);
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--path' => 'vendor/laravel/passport/database/migrations', '--force' => true]);
    \Illuminate\Support\Facades\Artisan::call('passport:install');

    return redirect()->back();
});
