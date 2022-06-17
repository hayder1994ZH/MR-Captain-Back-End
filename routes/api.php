<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardsController;
use App\Http\Controllers\VersionsController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\WeightHistoryController;
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

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);
Route::get('public/version', [VersionsController::class, 'index']);
Route::group(['middleware' => ['admin']], function() {
    Route::get('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/details', [AuthController::class, 'details']);
    Route::put('auth/profile', [AuthController::class, 'update']);
    Route::get('my/weight/histories', [WeightHistoryController::class, 'getMyWeightHistories']);
    Route::get('my/cards', [CardsController::class, 'getMyCards']);
    Route::get('my/subscriptions', [SubscriptionController::class, 'getMySubscriptions']);
    Route::get('my/advertisements', [AdvertisementController::class, 'getMyadvertisements']);
    Route::apiResource('user', 'UserController');
    Route::apiResource('rule', 'RulesController');
    Route::apiResource('gym', 'GymController');
    Route::apiResource('version', 'VersionsController');
    Route::apiResource('city', 'CityController');
    Route::apiResource('country', 'CountryController');
    Route::apiResource('weight/history', 'WeightHistoryController');
    Route::apiResource('card', 'CardsController');
    Route::apiResource('subscription', 'SubscriptionController');
    Route::apiResource('advertisement', 'AdvertisementController');
});
