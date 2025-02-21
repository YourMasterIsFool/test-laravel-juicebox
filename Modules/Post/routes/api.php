<?php

use Illuminate\Support\Facades\Route;
use Modules\Post\Http\Controllers\PostController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

Route::middleware(['auth:sanctum'])->prefix('post')->group(function () {
    // Route::apiResource('/', PostController::class)->names('post');
    Route::get('/list', [PostController::class, 'index'])->name('post.list');
    Route::post('/store', [PostController::class, 'store'])->name('post.create');
    Route::get('/detail/{id}', [PostController::class, 'show'])->name('post.show');
    Route::delete('/delete/{id}', [PostController::class, 'destroy'])->name('post.destroy');
    Route::patch('/update/{id}', [PostController::class, 'update'])->name('post.update');
});
