<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryPostsController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\GetUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RelatedPostController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

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

Broadcast::routes(['middleware' => ['auth:sanctum']]);
//////////////////////////////////////////////// PRIVATE ROUTES ////////////////////////////////////////////////
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->post('logout', [AuthenticatedSessionController::class, 'destroy']);
// categories only related to superuser
Route::middleware(['auth:sanctum', 'isSuperUser'])->post('categories/create', [CategoryController::class, 'store']);
Route::middleware(['auth:sanctum', 'isSuperUser'])->get('categories/{category}', [CategoryController::class, 'show']);
Route::middleware(['auth:sanctum', 'isSuperUser'])->put('categories/{category}', [CategoryController::class, 'update']);
Route::middleware(['auth:sanctum', 'isSuperUser'])->delete('categories/{category}', [CategoryController::class, 'destroy']);
// user list and others related to superuser
Route::middleware(['auth:sanctum', 'isSuperUser'])->get('/users', [GetUserController::class, 'index']);
Route::middleware(['auth:sanctum', 'isSuperUser'])->get('/user/{id}', [GetUserController::class, 'show']);
// posts
Route::middleware('auth:sanctum')->post('posts', [PostController::class, 'store']);
Route::middleware('auth:sanctum')->put('posts/{post:slug}', [PostController::class, 'update']);
Route::middleware('auth:sanctum')->delete('posts/{post:slug}', [PostController::class, 'destroy']);


// orders
Route::middleware('auth:sanctum')->get('/orders', [OrderController::class, 'index']);
Route::middleware('auth:sanctum')->get('/order/{id}', [OrderController::class, 'show']);
Route::middleware('auth:sanctum')->post('/buy-order/{postId}', [OrderController::class, 'buyOrder']);
Route::middleware('auth:sanctum')->post('/cancel-order/{orderId}', [OrderController::class, 'cancelOrder']);

// chat
Route::middleware('auth:sanctum')->post('/order/{id}/messages', [ChatController::class, 'store']);
Route::middleware('auth:sanctum')->get('/order/{id}/messages', [ChatController::class, 'getMessages']);



//////////////////////////////////////////////// PUBLIC ROUTES ////////////////////////////////////////////////
Route::post('register', [RegisteredUserController::class, 'store']);
Route::post('login', [AuthenticatedSessionController::class, 'store']);

// categories
Route::get('categories', [CategoryController::class, 'index']);

// posts
Route::get('home-posts', [HomeController::class, 'index']);
Route::get('posts/{post:slug}', [PostController::class, 'show']);
// categorya bo'yicha postlarni chaqirish
Route::get('posts', [CategoryPostsController::class, 'index']);

// Route::get('posts', [DashboardPostController::class, 'index']);

Route::get('related-posts/{post:slug}', [RelatedPostController::class, 'index']);
Route::get('dashboard-posts', [DashboardPostController::class, 'index']);
