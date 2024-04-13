<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryPostsController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\GetUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RelatedPostController;
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
Route::middleware(['auth:sanctum', 'verified', 'isSuperUser'])->post('categories/create', [CategoryController::class, 'store']);
Route::middleware(['auth:sanctum', 'verified', 'isSuperUser'])->get('categories/{category}', [CategoryController::class, 'show']);
Route::middleware(['auth:sanctum', 'verified', 'isSuperUser'])->put('categories/{category}', [CategoryController::class, 'update']);
Route::middleware(['auth:sanctum', 'verified', 'isSuperUser'])->delete('categories/{category}', [CategoryController::class, 'destroy']);
// user list and others related to superuser
Route::middleware(['auth:sanctum', 'verified', 'isSuperUser'])->get('/users', [GetUserController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified', 'isSuperUser'])->get('/user/{id}', [GetUserController::class, 'show']);
// posts
Route::middleware(['auth:sanctum', 'verified', 'isActive'])->post('posts', [PostController::class, 'store']);
Route::middleware(['auth:sanctum', 'verified', 'isActive'])->put('posts/{post:slug}', [PostController::class, 'update']);
Route::middleware(['auth:sanctum', 'verified', 'isActive'])->delete('posts/{post:slug}', [PostController::class, 'destroy']);


// orders
Route::middleware(['auth:sanctum', 'verified',])->get('/orders', [OrderController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified',])->get('/order/{id}', [OrderController::class, 'show']);
Route::middleware(['auth:sanctum', 'verified', 'isActive'])->post('/buy-order/{postId}', [OrderController::class, 'buyOrder']);
Route::middleware(['auth:sanctum', 'verified', 'isActive'])->post('/cancel-order/{orderId}', [OrderController::class, 'cancelOrder']);
// Inquiries
Route::middleware(['auth:sanctum', 'verified',])->get('/inquiries', [InquiryController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified',])->get('/inquiry/{id}', [InquiryController::class, 'show']);
// chat
Route::middleware(['auth:sanctum', 'verified', 'isActive'])->post('/order/{id}/messages', [ChatController::class, 'store']);
Route::middleware(['auth:sanctum', 'verified',])->get('/order/{id}/messages', [ChatController::class, 'getMessages']);



//////////////////////////////////////////////// PUBLIC ROUTES ////////////////////////////////////////////////
Route::post('register', [RegisterController::class, 'store']);
Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login');

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
