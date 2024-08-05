<?php

use App\Http\Controllers\Api\BookController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// route auth
Route::post('register', App\Http\Controllers\Api\RegisterController::class)->name('auth.register');

Route::post('login', App\Http\Controllers\Api\LoginController::class)->name('auth.login');
Route::post('logout', App\Http\Controllers\Api\LogoutController::class)->name('auth.logout');

Route::resource('books', BookController::class)
    ->except(['edit', 'create'])->middleware('auth:api');
