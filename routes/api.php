<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIAuthController;
use App\Http\Controllers\ActivityLogController;


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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/my_logs', [ActivityLogController::class, 'user_activity_log']);
});

Route::post('/register', [APIAuthController::class, 'register']);
Route::post('/login', [APIAuthController::class, 'login']);
