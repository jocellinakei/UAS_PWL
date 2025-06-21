<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BasicController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CategoryController;

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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/blank', function () {
    return view('blank');
})->name('blank');

Route::middleware('auth')->group(function() {
    Route::post('/news/{news}/publish', [NewsController::class, 'publish'])->name('news.publish');
    Route::resource('basic', \App\Http\Controllers\BasicController::class);
    Route::resource('news', \App\Http\Controllers\NewsController::class);
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
});