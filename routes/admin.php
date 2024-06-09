<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminBusinessController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminTalentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('connect/token', [AdminAuthController::class, 'connect']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('overview', [AdminController::class, 'overview']);
    Route::get('latest/jobs', [AdminController::class, 'latestJobs']);
    Route::get('visitors', [AdminController::class, 'visitors']);

    Route::prefix('talents')->controller(AdminTalentsController::class)->group(function () {
        Route::get('/all', 'index');
        Route::get('/single/{id}', 'singleTalent');
        Route::patch('/edit/{id}', 'editTalent');
        Route::delete('/delete/{id}', 'deleteTalent');
    });

    Route::prefix('business')->controller(AdminBusinessController::class)->group(function () {
        Route::get('/all', 'index');
        Route::get('/single/{id}', 'singleBusiness');
        Route::patch('/edit/{id}', 'editBusiness');
        Route::delete('/delete/{id}', 'deleteBusiness');
    });

    Route::post('add/user', [AdminAuthController::class, 'addUser']);

});



