<?php

use App\Http\Controllers\InformationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

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


Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', 'AuthController@logout')->middleware('auth:api'); Планы на будущее
// Route::post('/authenticate', [AuthController::class, 'authenticate']); Планы на будущее
Route::post('/information', [InformationController::class, 'store']);

