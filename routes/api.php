<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::controller(PostController::class)
    ->prefix('/posts')
    ->as('posts.')
    ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::prefix('{post}')->group(function() {
            Route::get('/', 'show')->name('show');
            Route::put('/', 'update')->name('update');
            Route::delete('/', 'destroy')->name('destroy');
            Route::delete('/force-delete', 'forceDestroy')->name('forceDestroy');
            Route::post('/restore', 'restore')->withTrashed()->name('restore');
        });

});

Route::controller(CategoryController::class)
    ->prefix('/categories')
    ->as('categories.')
    ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::prefix('{category}')->group(function() {
            Route::get('/', 'show')->name('show');
            Route::put('/', 'update')->name('update');
            Route::delete('/', 'destroy')->name('destroy');
            Route::delete('/force-delete', 'forceDestroy')->name('forceDestroy');
            Route::post('/restore', 'restore')->withTrashed()->name('restore');
        });
});

Route::controller(UserController::class)
    ->prefix('/users')
    ->as('users.')
    ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::prefix('{user}')->group(function() {
            Route::get('/', 'show')->name('show');
            Route::put('/', 'update')->name('update');
            Route::delete('/', 'destroy')->name('destroy');
            Route::delete('/force-delete', 'forceDestroy')->name('forceDestroy');
            Route::post('/restore', 'restore')->withTrashed()->name('restore');
        });
});

Route::controller(CommentController::class)
    ->prefix('/comments')
    ->as('comments.')
    ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::prefix('{comment}')->group(function() {
            Route::get('/', 'show')->name('show');
            Route::put('/', 'update')->name('update');
            Route::delete('/', 'destroy')->name('destroy');
            Route::delete('/force-delete', 'forceDelete')->name('forceDelete');
            Route::post('/restore', 'restore')->withTrashed()->name('restore');
        });
});