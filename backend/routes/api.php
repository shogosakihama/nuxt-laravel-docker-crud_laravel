<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use Laravel\Sanctum\Sanctum;
use App\Http\Controllers\Auth\Api\RegisterController;
use App\Http\Controllers\Auth\Api\LoginController;
use Illuminate\Support\Facades\Auth;


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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('like', [LikeController::class, 'like'])->middleware('auth');
// Route::get('index', [PostController::class, 'index']);
// Route::post('post', [PostController::class, 'store']);
// Route::post('update', [PostController::class, 'update']);
// Route::post('remove', [PostController::class, 'destroy']);

// Sanctum
Route::post('yy', [PostController::class, 'yy']);
Route::post('register', [RegisterController::class, 'register'])->name('api.register');
Route::post('login', [LoginController::class, 'login'])->name('api.login');

// Route::get('user', function (Request $request) {
//     return response()->json(['user' => $request->user()]);
// });
// Route::post('logout', [LoginController::class, 'logout'])->name('api.logout');

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('user', function (Request $request) {
        return response()->json(['user' => $request->user()]);
    });
    Route::post('logout', [LoginController::class, 'logout'])->name('api.logout');
    Route::post('like', [LikeController::class, 'like']);
    // Route::get('index', [PostController::class, 'index']);
    Route::post('post', [PostController::class, 'store']);
    Route::post('update', [PostController::class, 'update']);
    Route::post('remove', [PostController::class, 'destroy']);
    // Route::post('yy', [PostController::class, 'yy']);
});
Route::get('indexNoauth', [PostController::class, 'indexNoauth']);
Route::get('index', [PostController::class, 'index']);
