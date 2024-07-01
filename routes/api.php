<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryPostsController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\GetUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UpdateOrderStatusController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RelatedPostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use App\Facades\Payme;
use App\Http\Controllers\ClickController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReviewController;
use App\Http\Middleware\PaymeCheck;


Broadcast::routes(['middleware' => ['auth:sanctum']]);
//////////////////////////////////////////////// PRIVATE ROUTES ////////////////////////////////////////////////
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();
    $user->image_url = url('storage/' . $user->image);
    return $user;
});

// categories only related to superuser
Route::middleware(['auth:sanctum', 'verified', 'isSuperUser'])->post('/categories/create', [CategoryController::class, 'store']);
Route::middleware(['auth:sanctum', 'verified', 'isSuperUser'])->get('/categories/{category}', [CategoryController::class, 'show']);
Route::middleware(['auth:sanctum', 'verified', 'isSuperUser'])->put('/categories/{category}', [CategoryController::class, 'update']);
Route::middleware(['auth:sanctum', 'verified', 'isSuperUser'])->delete('/categories/{category}', [CategoryController::class, 'destroy']);
// user list and others related to superuser
Route::middleware(['auth:sanctum', 'verified', 'isSuperUser'])->get('/users', [GetUserController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified', 'isSuperUser'])->get('/user/{id}', [GetUserController::class, 'show']);
// posts
Route::middleware(['auth:sanctum', 'verified', 'isActive'])->post('/posts', [PostController::class, 'store']);
Route::middleware(['auth:sanctum', 'verified', 'isActive'])->put('/posts/{post:slug}', [PostController::class, 'update']);
Route::middleware(['auth:sanctum', 'verified', 'isActive'])->delete('/posts/{post:slug}', [PostController::class, 'destroy']);


// orders
Route::middleware(['auth:sanctum', 'verified',])->get('/orders', [OrderController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified',])->get('/order/{id}', [OrderController::class, 'show']);
Route::middleware(['auth:sanctum', 'verified', 'isActive'])->post('/buy-order/{postId}', [OrderController::class, 'buyOrder']);
Route::middleware(['auth:sanctum', 'verified', 'isActive'])->put('/update-order-status/{orderId}', [UpdateOrderStatusController::class, 'statusUpdate']);
Route::middleware(['auth:sanctum', 'verified', 'isActive'])->put('/force-majeure/{orderId}', [UpdateOrderStatusController::class, 'forceMajeure']);
// Route::middleware(['auth:sanctum', 'verified', 'isActive'])->post('/cancel-order/{orderId}', [UpdateOrderStatusController::class, 'cancelOrder']);
// Inquiries
Route::middleware(['auth:sanctum', 'verified',])->get('/inquiries', [InquiryController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified',])->get('/inquiry/{id}', [InquiryController::class, 'show']);
// chat
Route::middleware(['auth:sanctum', 'verified', 'isActive'])->post('/order/{id}/messages', [ChatController::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->post('/message/{id}', [ChatController::class, 'update']);
Route::middleware(['auth:sanctum', 'verified',])->get('/order/{id}/messages', [ChatController::class, 'getMessages']);
//review
Route::middleware(['auth:sanctum', 'verified', 'isActive'])->post('/review', [ReviewController::class, 'store']);
//complaint
Route::middleware(['auth:sanctum', 'verified', 'isActive'])->post('/complaint', [ComplaintController::class, 'store']);


//////////////////////////////////////////////// PUBLIC ROUTES ////////////////////////////////////////////////
// categories
Route::get('/menu_list', [MenuController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);

// posts
Route::get('/home-posts', [HomeController::class, 'index']);
Route::get('/posts/{post:slug}', [PostController::class, 'show']);
// categorya bo'yicha postlarni chaqirish
Route::get('/posts', [CategoryPostsController::class, 'index']);

// Route::get('posts', [DashboardPostController::class, 'index']);

Route::get('/related-posts/{post:slug}', [RelatedPostController::class, 'index']);
Route::get('/dashboard-posts', [DashboardPostController::class, 'index']);


// payme integration url
Route::any('/payme', function (Request $request) {
    return Payme::handle($request);
})->middleware(PaymeCheck::class);
Route::any('/click/prepare', [ClickController::class, 'prepare'])->name('click.prepare');
Route::any('/click/complete', [ClickController::class, 'complete'])->name('click.complete');
