<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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

        //profile routes
        Route::prefix('profile')->group(function () {
            //password
            Route::get('password/change', [AuthController::class, 'passwordChangePage'])->name('password#change');
            Route::post('password/change', [AuthController::class, 'passwordChange'])->name('change#password');

            //profile
            Route::get('detail', [AuthController::class, 'adminProfile'])->name('admin#profile');
            Route::get('update', [AuthController::class, 'adminProfileUpdatePage'])->name('admin#profile#updatePage');
            Route::post('update', [AuthController::class, 'adminProfileUpdate'])->name('admin#profile#update');

            //admin list
            Route::get('admin/list', [AuthController::class, 'adminList'])->name('admin#list');
            Route::delete('admin/delete', [AuthController::class, 'adminDelete'])->name('admin#delete');
            Route::post('admin/role', [AuthController::class, 'roleChange'])->name('admin#role#change');
        });

        //product routes
        Route::prefix('product')->group(function () {
            Route::get('list', [ProductController::class, 'productLists'])->name('product#list');
            Route::get('create', [ProductController::class, 'productCreatePage'])->name('product#create');
            Route::post('create', [ProductController::class, 'productCreate'])->name('product#create#post');
            Route::delete('delete', [ProductController::class, 'productDelete'])->name('product#delete');
            Route::get('detail/{id}', [ProductController::class, 'productDetail'])->name('product#detail');
            Route::get('edit/{id}', [ProductController::class, 'editPage'])->name('product#edit');
            Route::post('update/{id}', [ProductController::class, 'productUpdate'])->name('product#update');
        });
    });

    //user route with middleware
    Route::middleware('user')->group(function () {
        Route::get('user/home', [AuthController::class, 'user_home_page'])->name('user#home');
    });
});
