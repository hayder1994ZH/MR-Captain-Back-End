<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DayController;
use App\Http\Controllers\PushController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CardsController;
use App\Http\Controllers\DebtsController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\MuscleController;
use App\Http\Controllers\HandPayController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\VersionsController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CourseDayController;
use App\Http\Controllers\DayMuscleController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\WeightHistoryController;
use App\Http\Controllers\SubscriptionsGymController;
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
Route::post('auth/register/admin', [AuthController::class, 'registerAdmin']);
Route::apiResource('city', 'CityController');
Route::apiResource('country', 'CountryController');
Route::get('public/version/{version}', [VersionsController::class, 'getPublicVersion']);
Route::group(['middleware' => ['auth']], function() {
    Route::get('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/details', [AuthController::class, 'details']);
    Route::put('auth/profile', [AuthController::class, 'update']);
    Route::post('add/captain', [UserController::class, 'addCaptain']);
    Route::post('add/player', [UserController::class, 'addPlayer']);
    Route::get('logout/player/{id}', [UserController::class, 'RemovePlayerFromGym']);
    Route::post('add/player/subscription', [UserController::class, 'storePlayerWithSubscription']);
    Route::post('add/admin', [UserController::class, 'addAdmin']);
    Route::get('my/gym/users', [UserController::class, 'getMyGymUsers']);
    Route::get('admins/captains/info', [UserController::class, 'getAdminsOrCaptainsGym']);
    Route::get('player/info', [UserController::class, 'getPlayersGym']);
    Route::get('my/weight/histories', [WeightHistoryController::class, 'getMyWeightHistories']);
    Route::get('my/cards', [CardsController::class, 'getMyCards']);
    Route::get('my/subscriptions', [SubscriptionController::class, 'getMySubscriptions']);
    Route::post('add/by/last/subscription', [SubscriptionController::class, 'storeSubscripAboutLastSUbscription']);
    Route::get('my/advertisements', [AdvertisementController::class, 'getMyadvertisements']);
    Route::get('my/purchases', [PurchaseController::class, 'getMyPurchase']);
    Route::get('my/sales', [SaleController::class, 'getMySales']);
    Route::get('my/debts', [DebtsController::class, 'getMyDebts']);
    Route::get('my/gym/course', [CourseController::class, 'getMyGymCourses']);
    Route::get('my/gym/day', [DayController::class, 'getMyGymDays']);
    Route::get('my/gym/push', [PushController::class, 'getMyGymPushes']);
    Route::get('my/gym/training', [TrainingController::class, 'getMyGymTraininges']);
    Route::get('my/gym/muscle', [MuscleController::class, 'getMyGymMuscles']);
    Route::get('my/course', [CourseController::class, 'getMyCourses']);
    Route::get('full/course/{id}', [CourseController::class, 'getFullCourse']);
    Route::get('my/course/days', [CourseDayController::class, 'getMyCourseDays']);
    Route::get('my/day/muscles', [DayMuscleController::class, 'getMyGymDayMuscles']);
    Route::get('my/muscle/trainings', [MuscleTrainingController::class, 'getMyGymMuscleTrainings']);
    Route::get('my/subscriptions/gym', [SubscriptionsGymController::class, 'getMySubscriptions']);
    Route::get('my/hand/pay', [HandPayController::class, 'getMyDebts']);
    Route::get('total/my/purchases', [PurchaseController::class, 'getMyPurchaseTotalPrice']);
    Route::apiResource('user', 'UserController');
    Route::apiResource('rule', 'RulesController');
    Route::apiResource('gym', 'GymController');
    Route::apiResource('version', 'VersionsController');
    Route::apiResource('weight/history', 'WeightHistoryController');
    Route::apiResource('card', 'CardsController');
    Route::apiResource('subscription', 'SubscriptionController');
    Route::apiResource('advertisement', 'AdvertisementController');
    Route::apiResource('music', 'MusicController');
    Route::apiResource('purchase', 'PurchaseController');
    Route::apiResource('sale', 'SaleController');
    Route::apiResource('debt', 'DebtsController');
    Route::apiResource('hand/pay', 'HandPayController');
    Route::apiResource('course', 'CourseController');
    Route::apiResource('day', 'DayController');
    Route::apiResource('muscle', 'MuscleController');
    Route::apiResource('push', 'PushController');
    Route::apiResource('training', 'TrainingController');
    Route::apiResource('courses/days', 'CourseDayController');
    Route::apiResource('days/muscles', 'DayMuscleController');
    Route::apiResource('muscles/trainings', 'MuscleTrainingController');
    Route::apiResource('dashboard/gym/cards', 'CardsGymController');
    Route::apiResource('dashboard/gym/subscriptions', 'SubscriptionsGymController');
});
