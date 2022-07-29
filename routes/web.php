<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityCalenderController;
use App\Http\Controllers\ActivityController;

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

Route::get('/', function () {
    return view('auth/login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get('create', [ActivityController::class, 'create'])->name('created');
    Route::post('create', [ActivityController::class, 'store']);

    Route::get('/activity/{id}/change', [ActivityController::class, 'edit'])->name('edit');
    Route::put('/activity/{activity}', [ActivityController::class, 'update'])->name('update');

    Route::delete('/activity/{activity}', [ActivityController::class, 'destroy'])->name('destroy');


    Route::get('activity', [ActivityController::class, 'index'])->name('activity');
    Route::get('admin-activity', [ActivityController::class, 'admin_index'])->name('admin-activity');

    Route::get('dashboard', [ActivityCalenderController::class, 'index'])->name('dashboard');


});

