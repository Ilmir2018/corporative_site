<?php

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

Route::resource('/', \App\Http\Controllers\IndexController::class, [
    'only' => ['index'],
    'names' => [
        'index' => 'home'
    ]
]);

Route::resource('portfolios', \App\Http\Controllers\PortfolioController::class)->parameters([
    'portfolios' => 'alias'
]);

Route::resource('article', \App\Http\Controllers\ArticlesController::class)->parameters([
    'article' => 'alias'
]);

//Route::get('/', function () {
//    return view('welcome');
//});

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


