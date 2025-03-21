<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\MailController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ChartController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\OthersController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminJobsController;
use App\Http\Controllers\Admin\AdminMessageController;
use App\Http\Controllers\Admin\AdminTalentsController;
use App\Http\Controllers\Admin\AdminBusinessController;
use App\Http\Controllers\Admin\AdminExternalJobController;

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
Route::post('/file/upload', [OthersController::class, 'uploadFile']);

Route::prefix('lookups')->controller(OthersController::class)
->group(function () {
    Route::get('/countries', 'getCountries');
    Route::get('/state/{country_id}', 'getStates');
    Route::get('/skills', 'getSkills');
});

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('overview', [AdminController::class, 'overview'])
        ->middleware('cacheResponse:600');
    Route::get('latest/jobs', [AdminController::class, 'latestJobs'])
        ->middleware('cacheResponse:600');
    Route::get('visitors', [AdminController::class, 'visitors'])
        ->middleware('cacheResponse:600');

    Route::prefix('talents')->controller(AdminTalentsController::class)->group(function () {
        Route::get('/all', 'index');
        Route::get('/single/{id}', 'singleTalent');
        Route::patch('/edit/{id}', 'editTalent');
        Route::delete('/delete/{id}', 'deleteTalent');
        Route::get('/count', 'count');
    });

    Route::prefix('business')->controller(AdminBusinessController::class)->group(function () {
        Route::get('/all', 'index');
        Route::get('/single/{id}', 'singleBusiness');
        Route::patch('/edit/{id}', 'editBusiness');
        Route::delete('/delete/{id}', 'deleteBusiness');
        Route::get('/count', 'count');
    });

    Route::prefix('others')->controller(OthersController::class)->group(function () {
        Route::post('/forgot-password', 'forgot');
        Route::post('/business/forgot-password', 'businessForgot');

        Route::post('/create/jobtitle', 'createJobtitle');
        Route::get('/job-titles', 'allJobTitles');
        Route::get('/job-title/{id}', 'jobTitle');
        Route::patch('/edit/jobtitle/{id}', 'editJobTitle');
        Route::delete('/delete/jobtitle/{id}', 'deleteJobTitle');

        Route::post('/warning', 'warningMail');
        Route::post('/suspend', 'suspendUser');
        Route::post('/reactivate', 'reactivateUser');

        // Skills
        Route::get('/skills', 'allSkills');
        Route::post('/create/skill', 'createSkill');
        Route::get('/skill/{id}', 'skillDetail');
        Route::patch('/edit/skill/{id}', 'editSkill');
        Route::delete('/delete/skill/{id}', 'deleteSkill');
    });

    Route::prefix('blog')->controller(BlogController::class)->group(function () {
        // Category
        Route::get('/category', 'getAllCategory');
        Route::post('/category/create', 'blogCatCreate');
        Route::delete('/delete/category/{id}', 'deleteCategory');

        Route::post('/create', 'blogCreate');
        Route::get('/all', 'getAll');
        Route::get('/single/{id}', 'getOne');
        Route::post('/edit/{id}', 'editBlog');
        Route::delete('/delete/{id}', 'deleteBlog');
        Route::get('/count', 'count');
    });

    Route::prefix('event')->controller(EventController::class)->group(function () {
        Route::post('/create', 'eventCreate');
        Route::get('/all', 'getAll');
        Route::get('/single/{id}', 'getOne');
        Route::post('/edit/{id}', 'editEvent');
        Route::delete('/delete/{id}', 'deleteEvent');
        Route::get('/count', 'count');
        Route::get('/registered/{event_id}/count', 'registerEventCount');
        Route::get('/talent/registered/{event_id}', 'registerEvent');
        Route::post('/mail/settings', 'mailSetting');
        Route::get('/mail/settings/{event_id}', 'getMailSetting');
    });

    Route::prefix('jobs')->controller(AdminJobsController::class)->group(function () {
        Route::get('/all', 'index');
        Route::get('/single/{slug}', 'getOne');
        Route::get('/count', 'count');

        Route::post('/create', 'jobCreate');
        Route::patch('/close/{slug}', 'closeJob');
        Route::patch('/edit/{slug}', 'editJob');

        // Job charges
        Route::get('/charges', 'allCharges');
        Route::post('/create/charge', 'createCharge');
        Route::get('/charge/{id}', 'chargeDetail');
        Route::patch('/edit/charge/{id}', 'editCharge');
        Route::delete('/delete/charge/{id}', 'deleteCharge');
    });

    Route::prefix('external/job')->controller(AdminExternalJobController::class)->group(function () {
        Route::get('/all', 'index');
        Route::get('/single/{slug}', 'getOne');
        Route::get('/count', 'count');

        Route::post('/create', 'jobCreate');
        Route::patch('/edit/{slug}', 'editJob');
        Route::patch('/close/{slug}', 'closeJob');
    });

    Route::prefix('message')->controller(AdminMessageController::class)
        ->group(function () {
            Route::post('/send', 'sendMessage');

            // Talents
            Route::post('/talent/broadcast', 'talentBroadcastMessage');
            Route::get('/talent/messages', 'talentMessages')
                ->middleware('cacheResponse:600');
            Route::get('/talent/message/{id}', 'talentMessageDetails');
            Route::patch('/update/talent/message/{id}', 'updateTalentMessage');
            Route::delete('/delete/talent/message/{id}', 'deleteTalentMessage');

            // Business
            Route::post('/business/broadcast', 'businessBroadcastMessage');
            Route::get('/business/messages', 'businessMessages');
            Route::get('/business/message/{id}', 'businessMessageDetails');
            Route::patch('/update/business/message/{id}', 'updateBusinessMessage');
            Route::delete('/delete/business/message/{id}', 'deleteBusinessMessage');
        });

    Route::prefix('chart')
        ->middleware('cacheResponse:600')
        ->controller(ChartController::class)
        ->group(function () {
            Route::get('/revenue', 'getRevenueChart');
            Route::get('/visitors', 'getVisitors');
        });


    Route::post('add/user', [AdminAuthController::class, 'addUser']);
    Route::post('mail/sendmail', [MailController::class, 'sendMail']);

});



