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

Route::get('/user', function (GetUserRequest $request) {
    return auth()->user();
});