<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Http\Controllers\UserController;

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

Route::middleware('user-auth')->group(function () {
    // User api
    Route::get('users/', [UserController::class, 'getAllUsers']);
    Route::get('users/{id}', [UserController::class, 'getOneUser']);
    Route::post('users/', [UserController::class, 'updateUser']);
    Route::post('users/profilepicture', [UserController::class, 'updateProfilePicture']);
    Route::post('users/removeprofilepicture', [UserController::class, 'deleteProfilePicture']);
    Route::post('users/notification', 'UserController@'); //Not done
    Route::post('users/signout', [UserController::class, 'signout']); 
    Route::delete('users/', 'UserController@'); //Not done
});
