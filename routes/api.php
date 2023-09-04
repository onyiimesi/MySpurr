<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\BusinessOnboardingController;
use App\Http\Controllers\V1\GoogleAuthController;
use App\Http\Controllers\V1\JobController;
use App\Http\Controllers\V1\TalentJobsController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('v1/login', [AuthController::class, 'login']);
Route::post('v1/talent-register', [AuthController::class, 'talentRegister']);
Route::post('v1/business-register', [AuthController::class, 'businessRegister']);

Route::get('/verify/{token}', [AuthController::class, 'verify'])->name('verification.verify');
Route::get('/business-verify/{token}', [AuthController::class, 'verifys'])->name('verification.verifys');

Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

Route::get('/business/auth/google', [GoogleAuthController::class, 'redirectToGoogleBusiness']);
Route::get('/business/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallbackBusiness']);

Route::group(['middleware' => ['auth:sanctum']], function(){

    // Talent
    Route::post('v1/talent-work-details', [TalentOnboardingController::class, 'workDetails']);
    Route::post('v1/talent-portfolio', [TalentOnboardingController::class, 'portfolio']);
    Route::patch('v1/talent-edit-profile', [TalentOnboardingController::class, 'editProfile']);
    Route::get('v1/get-jobs', [TalentJobsController::class, 'jobs']);
    Route::post('v1/job-apply/{id}', [TalentJobsController::class, 'apply']);





    // Business
    Route::post('v1/business-details', [BusinessOnboardingController::class, 'businessDetails']);
    Route::post('v1/business-portfolio', [BusinessOnboardingController::class, 'portfolio']);
    Route::patch('v1/business-edit-profile', [BusinessOnboardingController::class, 'editProfile']);
    Route::resource('v1/job', JobController::class);


    Route::post('v1/logout', [AuthController::class, 'logout']);
});
