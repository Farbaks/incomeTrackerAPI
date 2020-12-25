<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/resetmail', function() {
//     $user = array([
//         'name' => 'James'
//     ]);
//     return view('resetpasswordmail', ['name' => 'James']);
// });
Route::get('/job/{jobId}/{type}', [JobController::class, 'viewQuotation']);
