<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// USAGE CONTROLLER 
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\NewsCommentController;
use App\Http\Controllers\Api\CustomPageController;

/**
 * route "/register"
 * @method "POST"
 */
Route::post('/register', RegisterController::class)->name('register');

/**
 * route "/login"
 * @method "POST"
 */
Route::post('/login', LoginController::class)->name('login');

/**
 * route "/user"
 * @method "GET"
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * route "/logout"
 * @method "POST"
 */
Route::middleware('auth:api')->post('/logout', LogoutController::class)->name('logout');

/**
 * route "/category"
 */
Route::middleware('auth:api')->prefix('category')->group(function () {
    Route::get('/', [CategoryController::class, 'get'])->name('get_category');
    Route::get('/{id}', [CategoryController::class, 'detail'])->name('get_detail_category');
    Route::post('/', [CategoryController::class, 'create'])->name('create_category');
    Route::put('/{id}', [CategoryController::class, 'update'])->name('update_category');
    Route::delete('/{id}', [CategoryController::class, 'delete'])->name('delete_category');
});

/**
 * route "/news"
 */
Route::prefix('news')->group(function () {
    Route::get('/', [NewsController::class, 'get'])->name('get_news');
    Route::get('/{id}', [NewsController::class, 'detail'])->name('get_detail_news');
    Route::middleware('auth:api')->group(function () {
        Route::post('/', [NewsController::class, 'create'])->name('create_news');
        Route::put('/{id}', [NewsController::class, 'update'])->name('update_news');
        Route::delete('/{id}', [NewsController::class, 'delete'])->name('delete_news');
    });
    Route::post('/comment', [NewsCommentController::class, 'create'])->name('create_comment');
});

/**
 * route "/custom-page"
 */
Route::prefix('custom-page')->group(function () {
    Route::get('/', [CustomPageController::class, 'get'])->name('get_custom_page');
    Route::get('/{id}', [CustomPageController::class, 'detail'])->name('get_detail_custom_page');
    Route::middleware('auth:api')->group(function () {
        Route::post('/', [CustomPageController::class, 'create'])->name('create_custom_page');
        Route::put('/{id}', [CustomPageController::class, 'update'])->name('update_custom_page');
        Route::delete('/{id}', [CustomPageController::class, 'delete'])->name('delete_custom_page');
    });
});