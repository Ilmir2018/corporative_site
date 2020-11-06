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

Route::resource('/', '\App\Http\Controllers\IndexController', [
    'only' => ['index'],
    'names' => [
        'index' => 'home'
    ]
]);


Route::resource('portfolios', '\App\Http\Controllers\PortfolioController')->parameters([
    'portfolios' => 'alias'
]);

Route::resource('article', '\App\Http\Controllers\ArticlesController')->parameters([
    'article' => 'alias'
]);

Route::get('article/cat/{cat_alias?}', [\App\Http\Controllers\ArticlesController::class, 'index'])
    ->name('articleCat')->where('cat_alias', '[\w-]+');


Route::resource('comment', '\App\Http\Controllers\CommentController')->parameters([
    'only' => ['store']
]);

Route::match(['get', 'post'], '/contacts', [\App\Http\Controllers\ContactsController::class, 'index'])->name('contacts');

Route::get('login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']);
Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout']);

//admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {

    //admin
    Route::get('/', [\App\Http\Controllers\Admin\IndexController::class, 'index'])->name('adminIndex');
    Route::get('/articles', [\App\Http\Controllers\Admin\ArticlesController::class, 'index'])->name('articles.index');
    Route::post('/articles/create', [\App\Http\Controllers\Admin\ArticlesController::class, 'create'])->name('admin.articles.create');
    Route::put('/articles/{articles}/update', [\App\Http\Controllers\Admin\ArticlesController::class, 'update'])->name('admin.articles.update');
    Route::post('/articles/store', [\App\Http\Controllers\Admin\ArticlesController::class, 'store'])->name('admin.articles.store');
    Route::get('/articles/{articles}/edit', [\App\Http\Controllers\Admin\ArticlesController::class, 'edit'])->name('admin.articles.edit');
    Route::delete('/articles/{articles}/delete', [\App\Http\Controllers\Admin\ArticlesController::class, 'destroy'])->name('admin.articles.delete');
});


