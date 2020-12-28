<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobController;

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
Route::post('users/signup', [UserController::class, 'signup']);
Route::post('users/signin', [UserController::class, 'signin']);
Route::post('users/reset', [UserController::class, 'resetPassword']); 
// Route::get('quotation/{id}', [JobController::class, 'viewQuotation']);

Route::middleware('user-auth')->group(function () {
    // User api
    Route::get('users/', [UserController::class, 'getAllUsers']);
    Route::get('user/', [UserController::class, 'getThisUser']);
    Route::get('users/{id}', [UserController::class, 'getOneUser']);
    Route::post('users', [UserController::class, 'updateUser']);
    Route::post('users/logo', [UserController::class, 'updateLogo']);
    Route::delete('users/logo', [UserController::class, 'deleteLogo']);
    Route::post('users/password', [UserController::class, 'changePassword']); 
    Route::post('users/signout', [UserController::class, 'signout']); 
    Route::post('users/token', [UserController::class, 'checkToken']);

    // Jobs api
    Route::post('jobs/new', [JobController::class, 'createJob']);
    Route::put('jobs/status', [JobController::class, 'editJobStatus']);
    Route::put('jobs/', [JobController::class, 'editJob']);
    Route::delete('jobs/{id}', [JobController::class, 'deleteJob']);
    Route::post('jobs', [JobController::class, 'getAllJobs']);
    Route::get('job/{id}', [JobController::class, 'getJob']);
    Route::post('quotation/new', [JobController::class, 'createQuotation']);
    Route::post('quotation', [JobController::class, 'editQuotation']);
    Route::get('jobs/report', [JobController::class, 'getReport']); 
    
});
