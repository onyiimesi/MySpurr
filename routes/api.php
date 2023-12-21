<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\BankAccountController;
use App\Http\Controllers\V1\BusinessOnboardingController;
use App\Http\Controllers\V1\ContactController;
use App\Http\Controllers\V1\ForgotPasswordController;
use App\Http\Controllers\V1\GoogleAuthController;
use App\Http\Controllers\V1\JobController;
use App\Http\Controllers\V1\MessageController;
use App\Http\Controllers\V1\OtherController;
use App\Http\Controllers\V1\PortfolioController;
use App\Http\Controllers\V1\ProfileController;
use App\Http\Controllers\v1\ResetPasswordController;
use App\Http\Controllers\V1\SettingsController;
use App\Http\Controllers\V1\SkillsController;
use App\Http\Controllers\V1\TalentController;
use App\Http\Controllers\V1\TalentJobsController;
use App\Http\Controllers\V1\TalentOnboardingController;
use App\Http\Controllers\V1\TalentProfileUpdateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
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

Route::get('/verify/{token}', [AuthController::class, 'verify'])->name('verification.verify');
Route::get('/business-verify/{token}', [AuthController::class, 'verifys'])->name('verification.verifys');
// Route::get('/auth/talent/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('verify', [AuthController::class, 'verifyuser']);
    Route::post('talent-register', [AuthController::class, 'talentRegister']);
    Route::post('business-register', [AuthController::class, 'businessRegister']);
    Route::post('forgot-password', [ForgotPasswordController::class, 'forgot']);
    Route::post('reset-password', [ResetPasswordController::class, 'reset']);
    Route::post('resend', [AuthController::class, 'resend'])->name('verification.resend');
    Route::get('auth/talent/google', [GoogleAuthController::class, 'redirectToGoogle']);
    Route::resource('skills', SkillsController::class);
    Route::get('list-jobs', [TalentJobsController::class, 'listjobs']);
    Route::get('job-title', [TalentController::class, 'jobtitle']);
    Route::get('talents', [TalentController::class, 'listtalents']);
    Route::get('talent/{uuid}', [TalentController::class, 'talentbyid']);
    Route::get('talent/portfolio/{id}', [PortfolioController::class, 'noAuth']);
    Route::get('talent/portfolio/single/{id}', [PortfolioController::class, 'singleports']);
    Route::post('contact-us', [ContactController::class, 'contact']);
    Route::get('contact-us', [ContactController::class, 'getcontact']);
    Route::post('subscribe', [ContactController::class, 'subscribe']);
    Route::get('subscribe', [ContactController::class, 'getsubscribe']);
    Route::get('country', [OtherController::class, 'country']);
});

// Route::get('/auth/business/google', [GoogleAuthController::class, 'redirectToGoogleBusiness']);
// Route::get('/auth/business/google/callback', [GoogleAuthController::class, 'handleGoogleCallbackBusiness']);

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'v1'], function(){

    // Talent
    Route::post('talent-work-details', [TalentOnboardingController::class, 'workDetails']);
    Route::post('talent-portfolio', [TalentOnboardingController::class, 'portfolio']);
    Route::get('get-jobs', [TalentJobsController::class, 'jobs']);
    Route::post('job-apply/{id}', [TalentJobsController::class, 'apply']);

    // Profile Edit
    Route::patch('update-photo', [TalentProfileUpdateController::class, 'updatePhoto']);
    Route::patch('update-bio', [TalentProfileUpdateController::class, 'updateBio']);
    Route::patch('update-overview', [TalentProfileUpdateController::class, 'updateOverview']);
    Route::post('add-skills', [TalentProfileUpdateController::class, 'updateSkills']);
    Route::post('add-education', [TalentProfileUpdateController::class, 'updateEdu']);
    Route::post('add-work-details', [TalentProfileUpdateController::class, 'updateWork']);
    Route::get('portfolio/{id}', [PortfolioController::class, 'auth']);
    Route::post('add-certificate', [TalentProfileUpdateController::class, 'addCert']);
    Route::patch('update-certificate/{id}', [PortfolioController::class, 'updateCert']);
    Route::get('bank-list', [BankAccountController::class, 'banks']);
    Route::post('add-bank-account', [BankAccountController::class, 'add']);
    Route::post('pin', [BankAccountController::class, 'pin']);
    Route::post('verify-pin', [BankAccountController::class, 'verify']);
    Route::patch('update-education/{id}', [PortfolioController::class, 'updateEdu']);
    Route::patch('update-employment/{id}', [PortfolioController::class, 'updateEmp']);
    Route::patch('update-portfolio/{id}', [PortfolioController::class, 'updatePort']);
    Route::get('portfolio/single/{id}', [PortfolioController::class, 'singleport']);

    // Settings
    Route::patch('accounts/{talent_id}', [SettingsController::class, 'accounts']);
    Route::delete('delete-account/{talent_id}', [SettingsController::class, 'deleteaccount']);

    // Business
    Route::post('business-details', [BusinessOnboardingController::class, 'businessDetails']);
    Route::post('business-portfolio', [BusinessOnboardingController::class, 'portfolio']);
    Route::patch('business-edit-profile', [BusinessOnboardingController::class, 'editProfile']);
    Route::resource('job', JobController::class);

    // Messaging
    Route::get('message/{recieverId}', [MessageController::class, 'index']);
    Route::post('message/{recieverId}', [MessageController::class, 'store']);
    Route::post('upload-identity', [TalentProfileUpdateController::class, 'upload']);

    //Wallet
    Route::get('wallet', [ProfileController::class, 'wallet']);

    //Open Tickect
    Route::post('ticket', [OtherController::class, 'ticket']);
    Route::get('ticket', [OtherController::class, 'allticket']);
    Route::get('get-ticket/{id}', [OtherController::class, 'ticketId']);
    Route::get('talent-ticket/{talent_id}', [OtherController::class, 'ticketTalentId']);
    Route::patch('close-ticket/{id}', [OtherController::class, 'closeticket']);

    Route::get('profile', [ProfileController::class, 'profile']);
    Route::patch('change-password', [AuthController::class, 'change']);

    Route::post('logout', [AuthController::class, 'logout']);
});
