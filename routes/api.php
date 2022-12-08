<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EnvironmentController;

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

Route::post('/getCompany', [CompanyController::class, 'index']);
Route::post('/getEnvironment', [EnvironmentController::class, 'index']);
Route::post('/getYear', [EnvironmentController::class, 'getYear']);
Route::post('/getEmossionRank', [EnvironmentController::class, 'getEmossionRank']);
Route::post('/getReductionRank', [EnvironmentController::class, 'getReductionRank']);
Route::post('/getDetail', [EnvironmentController::class, 'getDetail']);
