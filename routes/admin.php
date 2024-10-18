<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OthersController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminTalentsController;
use App\Http\Controllers\Admin\AdminBusinessController;
use App\Http\Controllers\Admin\AdminJobsController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\MailController;

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
});

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('overview', [AdminController::class, 'overview']);
    Route::get('latest/jobs', [AdminController::class, 'latestJobs']);
    Route::get('visitors', [AdminController::class, 'visitors']);

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
    });

    Route::post('add/user', [AdminAuthController::class, 'addUser']);
    Route::post('mail/sendmail', [MailController::class, 'sendMail']);

});



