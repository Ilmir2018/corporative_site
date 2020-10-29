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

Route::get('article/cat/{cat_alias?}', [\App\Http\Controllers\ArticlesController::class, 'index'])
    ->name('articleCat')->where('cat_alias', '[\w-]+');


Route::resource('comment', \App\Http\Controllers\CommentController::class)->parameters([
    'only' => ['store']
]);

Route::match(['get', 'post'], '/contacts', [\App\Http\Controllers\ContactsController::class, 'index'])->name('contacts');

Route::get('login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']);
Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout']);


