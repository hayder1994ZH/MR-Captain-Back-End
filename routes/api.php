<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\ReelsController;
use App\Http\Controllers\SplashController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BlockUserController;
use App\Http\Controllers\FollowersController;
use App\Http\Controllers\LikeCommentsController;
use App\Http\Controllers\NotificationsController;
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
Route::get('auth/first/request', [AuthController::class, 'firstRequest']);
Route::get('public/version', [VersionsController::class, 'index']);
Route::get('get/active/splash', [SplashController::class, 'getActiveSplash']);
Route::group(['middleware' => ['admin']], function() {
    Route::get('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/details', [AuthController::class, 'details']);
    Route::put('auth/profile', [AuthController::class, 'update']);
    Route::post('reels/script', [ReelsController::class, 'storeScript']);
    Route::get('my/followers', [FollowersController::class, 'myFollowers']);
    Route::get('my/followings', [FollowersController::class, 'myFollowings']);
    Route::get('my/likes', [LikesController::class, 'mylikes']);
    Route::get('likes/reel/{id}', [LikesController::class, 'reelLikes']);
    Route::get('my/likes/comments', [LikeCommentsController::class, 'mylikeComments']);
    Route::get('likes/comment/{id}', [LikeCommentsController::class, 'LikesComment']);
    Route::post('personal/chat/user/{id}', [ChatsController::class, 'personalChat']);
    Route::get('users/group/{chat}', [ChatsController::class, 'getUsersGroup']);
    Route::post('chat/public', [ChatsController::class, 'publicGroup']);
    Route::post('add/user', [ChatsController::class, 'addUserToGroup']);
    Route::post('add/users', [ChatsController::class, 'addUsersToGroup']);
    Route::get('messages/chat/{chatId}', [MessagesController::class, 'getMessagesByChatId']);
    Route::get('my/chats', [ChatsController::class, 'getMyPersonalChats']);
    Route::get('my/groups', [ChatsController::class, 'getListMyGroups']);
    Route::get('my/notification', [NotificationsController::class, 'index']);
    Route::delete('user/message/{message}', [MessagesController::class, 'userDeleteMessage']);
    Route::delete('user/message/{message}', [MessagesController::class, 'userDeleteMessage']);
    Route::get('my/block/users', [BlockUserController::class, 'getAllMyUserBlock']);
    Route::get('follower/reels', [ReelsController::class, 'getUserFollowedReels']);
    Route::get('active/splash/{id}', [SplashController::class, 'activeSplash']);
    Route::apiResource('block/users', 'BlockUserController');
    Route::apiResource('user', 'UserController');
    Route::apiResource('rule', 'RulesController');
    Route::apiResource('reels',  'ReelsController');
    Route::apiResource('comments', 'CommentsController');
    Route::apiResource('follow', 'FollowersController');
    Route::apiResource('like', 'LikesController');
    Route::apiResource('chat', 'ChatsController');
    Route::apiResource('companies', 'CompaniesController');
    Route::apiResource('message', 'MessagesController');
    Route::apiResource('likes/comment', 'LikeCommentsController');
    Route::apiResource('version', 'VersionsController');
    Route::apiResource('splash', 'SplashController');
});
