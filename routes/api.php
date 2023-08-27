<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Panel\ArticleController;
use App\Http\Controllers\User\CodeCheckController;
use App\Http\Controllers\User\ForgotPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user()->getRoleNames();
//});

Route::prefix('user')->group(function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [LoginController::class, 'loginUser']);
});

Route::post('register', [RegisterController::class, 'register']);

Route::group(['middleware' => ['role:admin|moderator', 'auth:sanctum']], function () {
    Route::prefix('article')->group(function () {
        Route::get('/', [ArticleController::class, 'list']);
        Route::delete('/{article_id}', [ArticleController::class, 'remove']);
        Route::post('/', [ArticleController::class, 'add']);
        Route::patch('/{article_id}', [ArticleController::class, 'edit']);
    });
});

Route::post('/user/forgot-password', [ForgotPasswordController::class, '__invoke']);
Route::post('/user/code-check', [CodeCheckController::class, '__invoke']);

Route::group(['middleware' => ['role:admin', 'auth:sanctum']], function () {
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'list']);
        Route::patch('/{user_id}', [UserController::class, 'editRole']);
    });
});

