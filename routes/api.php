<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\GetUserRequest;

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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/planning', function () {
    });
});

Route::get('/logout', [\App\Http\Controllers\SanctumAuthController::class, 'logout']);

Route::prefix('event')->group(function () {
    Route::post('/create', [\App\Http\Controllers\EventController::class, 'create']);
    Route::get('/{event}', [\App\Http\Controllers\EventController::class, 'show']);
    Route::post('/update/{event}', [\App\Http\Controllers\EventController::class, 'update']);
    Route::get('/destroy/{event}', [\App\Http\Controllers\EventController::class, 'destroy']);
});

Route::prefix('user')->group(function () {
    Route::post('/create', [\App\Http\Controllers\SanctumAuthController::class, 'create']);
    Route::get('/{user}', [\App\Http\Controllers\SanctumAuthController::class, 'show']);
    Route::post('/update/{user}', [\App\Http\Controllers\SanctumAuthController::class, 'update']);
    Route::get('/destroy/{user}', [\App\Http\Controllers\SanctumAuthController::class, 'destroy']);
});

Route::get('/users', function () {
    abort_unless(auth()->check(), 501);
    return User::get();
});