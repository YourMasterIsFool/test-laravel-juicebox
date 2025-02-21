<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::get('/list', [UserController::class, 'index'])->name('user.list');
    Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');
    Route::get('/detail/{id}', [UserController::class, 'getDetail'])->name('user.detail');
});

// auth register
Route::post('/register', [UserController::class, 'register'])->name('user.register');
Route::post('/login', [UserController::class, 'login'])->name('user.login');
