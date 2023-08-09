<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\TalentOnboardingController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('v1/login', [AuthController::class, 'login']);
Route::post('v1/talent-register', [AuthController::class, 'talentRegister']);

Route::get('/verify/{token}', [AuthController::class, 'verify'])->name('verification.verify');
// Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
// Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::group(['middleware' => ['auth:sanctum']], function(){

    Route::post('v1/talent-work-details', [TalentOnboardingController::class, 'workDetails']);
    Route::post('v1/talent-portfolio', [TalentOnboardingController::class, 'portfolio']);

});
