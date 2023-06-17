<?php

use App\Models\User;
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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/planning', function () {
    });
});

Route::get('/logout', [\App\Http\Controllers\SanctumAuthController::class, 'logout']);

Route::prefix('user')->group(function () {
    Route::post('/create', [\App\Http\Controllers\SanctumAuthController::class, 'create']);
    Route::get('/{user}', [\App\Http\Controllers\SanctumAuthController::class, 'show']);
    Route::post('/update/{user}', [\App\Http\Controllers\SanctumAuthController::class, 'update']);
    Route::get('/destroy/{user}', [\App\Http\Controllers\SanctumAuthController::class, 'destroy']);
});

Route::prefix('evenement')->group(function () {
    Route::post('/create', [\App\Http\Controllers\EvenementController::class, 'create']);
    Route::get('/all', [\App\Http\Controllers\EvenementController::class, 'index']);
    Route::get('/{event}', [\App\Http\Controllers\EvenementController::class, 'show']);
    Route::post('/update/{event}', [\App\Http\Controllers\EvenementController::class, 'update']);
    Route::get('/delete/{event}', [\App\Http\Controllers\EvenementController::class, 'destroy']);
});

Route::get('/users', function () {
    abort_unless(auth()->check(), 501);
    return auth()->user();
});