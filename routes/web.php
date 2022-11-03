<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

//Auth Customization ...
Route::get('/', [AuthController::class, 'AuthOrNot'])->name('auth#initial');

Route::middleware(['auth_middleware'])->group(function () {
    Route::get('loginPage', [AuthController::class, 'login'])->name('auth#login');
    Route::get('registerPage', [AuthController::class, 'register'])->name('auth#register');
});

//after authenticated processes ...
Route::middleware('auth')->group(function () {
    //admin route with middleware
    Route::middleware('admin')->group(function () {
        //category routes
        Route::prefix('category')->group(function () {
            Route::get('list', [CategoryController::class, 'list'])->name('category#list');
            Route::post('create', [CategoryController::class, 'create'])->name('category#create');
            Route::delete('delete', [CategoryController::class, 'delete'])->name('category#delete');
            Route::post('edit', [CategoryController::class, 'edit'])->name('category#edit');
        });
    });
    //user route with middleware
    Route::middleware('user')->group(function () {
        Route::get('user/home', [AuthController::class, 'user_home_page'])->name('user#home');
    });
});
