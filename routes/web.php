<?php

use App\Http\Controllers\AdminDashboardControllers\OrdersController;
use App\Http\Controllers\AdminDashboardControllers\PostsController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\VerificationNoticeController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

*/

Route::get('/password-reset', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/password-reset', [PasswordResetController::class, 'reset'])->name('password.reset');


Route::get('/email/verify/notice', [VerificationNoticeController::class, 'showNotice'])
    ->middleware(['auth'])
    ->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware('auth')->name('verification.verify');

// here started all admin Routes
Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    // routes/web.php
    Route::get('/search', [SearchController::class, 'search'])->name('admin.search');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'index'])->name('profile');
    Route::get('/user-profile', [UserController::class, 'edit'])->name('user-profile');
    Route::get('/billing', [PaymentController::class, 'index'])->name('billing');
    Route::middleware('isActive')->group(function () {
        Route::put('/user-profile/update', [UserController::class, 'update'])->name('user-profile.update');
    });
});



// super user routes
Route::group(['prefix' => 'admin', 'middleware' => ['isSuperUser', 'auth', 'verified']], function () {
    Route::get('/user-management', [UserManagementController::class, 'index'])->name('user-management');
    Route::put('/user-edit/{id}', [UserManagementController::class, 'update'])->name('user-edit');
    Route::get('/posts', [PostsController::class, 'index'])->name('posts');
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints');
    Route::put('/complaint/{id}', [ComplaintController::class, 'update'])->name('complaint-update');
    Route::get('/post/{id}', [PostsController::class, 'show'])->name('post.id');
    Route::put('/post/{id}', [PostsController::class, 'update'])->name('post.id');
    Route::get('/orders', [OrdersController::class, 'index'])->name('orders');
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
    Route::put('/review/{id}', [ReviewController::class, 'update'])->name('review-update');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('user.id');
});

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
