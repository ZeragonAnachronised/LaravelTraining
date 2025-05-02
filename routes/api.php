<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'profile']);
    Route::get('/user/{user_id}', [UserController::class, 'other']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/event/{event_id}', [EventController::class, 'other']);
    Route::delete('/user/{user_id}', [UserController::class, 'destroy']);
    Route::get('/session_down', [UserController::class, 'sessionDown']);
    Route::get('/all_down', [UserController::class, 'allDown']);
});
Route::post('/reg', [UserController::class, 'reg']);
Route::post('/auth', [UserController::class, 'auth']);
Route::patch('/user', [UserController::class, 'redact']);
Route::fallback([EventController::class, 'notFound']);