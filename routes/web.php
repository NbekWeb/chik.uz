<?php

use App\Http\Controllers\AdminDashboardControllers\OrdersController;
use App\Http\Controllers\AdminDashboardControllers\PostsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PostShowController;
use Illuminate\Support\Facades\Route;

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
// here started all admin Routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    // Routes needing 'auth'' middleware
    Route::get('/profile', [UserController::class, 'index'])->name('profile');
    Route::get('/user-profile', [UserController::class, 'edit'])->name('user-profile');
    // Routes needing 'auth'|| 'isActive' middleware
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/billing', [PaymentController::class, 'index'])->name('billing');
    Route::middleware('isActive')->group(function () {
        Route::put('/user-profile/update', [UserController::class, 'update'])->name('user-profile.update');
    });
});



// super user routes
Route::group(['prefix' => 'admin', 'middleware' => ['isSuperUser', 'auth']], function () {
    Route::get('/user-management', [UserManagementController::class, 'index'])->name('user-management');
    Route::put('/user-edit/{id}', [UserManagementController::class, 'update'])->name('user-edit');
    Route::get('/posts', [PostsController::class, 'index'])->name('posts');
    Route::get('/post/{id}', [PostsController::class, 'show'])->name('post.id');
    Route::get('/orders', [OrdersController::class, 'index'])->name('orders');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('user.id');
});

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
