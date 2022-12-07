<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Ajax\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\UserController;
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
            Route::get('password/change', [AdminController::class, 'passwordChangePage'])->name('password#change');
            Route::post('password/change', [AdminController::class, 'passwordChange'])->name('change#password');

            //profile
            Route::get('detail', [AdminController::class, 'adminProfile'])->name('admin#profile');
            Route::get('update', [AdminController::class, 'adminProfileUpdatePage'])->name('admin#profile#updatePage');
            Route::post('update', [AdminController::class, 'adminProfileUpdate'])->name('admin#profile#update');

            //admin list
            Route::get('admin/list', [AdminController::class, 'adminList'])->name('admin#list');
            Route::delete('admin/delete', [AdminController::class, 'adminDelete'])->name('admin#delete');
            Route::post('admin/role', [AdminController::class, 'roleChange'])->name('admin#role#change');
            Route::get('admin/role/ajax', [AdminController::class, 'adminRoleAjax'])->name('admin#role#ajax');

            //user list
            Route::get('user/list', [AdminController::class, 'userList'])->name('user#list');
            Route::delete('user/delete', [AdminController::class, 'userDelete'])->name('user#delete');
            Route::get('user/edit/page/{id}', [AdminController::class, 'userEditPage'])->name('user#edit#page');
            Route::post('user/edit', [AdminController::class, 'userEdit'])->name('user#edit');
            Route::get('user/role/ajax', [AdminController::class, 'userRoleAjax'])->name('user#role#ajax');
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

        //order routes
        Route::prefix('order')->group(function () {
            Route::get('list', [OrderController::class, 'listPage'])->name('admin#order#list');
            Route::get('items/{order_code}', [OrderController::class, 'itemPage'])->name('admin#order#item');
        });

        //admin order list
        Route::get('list', [OrderController::class, 'orderList'])->name('ajax#order#admin');
        Route::get('ajax/status', [OrderController::class, 'status'])->name('ajax#status#admin');

        //Contact List
        Route::get('contact/list', [ContactController::class, 'contactListPage'])->name('admin#contact#list#page');
        Route::get('contact/remove', [ContactController::class, 'removeAll'])->name('ajax#contact#removeAll');
    });

    //user route with middleware
    Route::group(['middleware' => 'user', 'prefix' => 'user'], function () {

        //home page
        Route::get('home', [UserController::class, 'user_home_page'])->name('user#home');
        //category filter
        Route::get('filter/{id}', [UserController::class, 'categoryFilter'])->name('category#filter');
        //Pizza Detail
        Route::prefix('pizza')->group(function () {
            Route::get('detail/{id}', [UserController::class, 'pizzaDetail'])->name('pizza#detail');
        });
        //pizza cart
        Route::get('cart/list', [UserController::class, 'cartlist'])->name('pizza#cart');
        //order history
        Route::get('order/history', [UserController::class, 'orderHistory'])->name('order#history');
        //password
        Route::get('password/change', [UserController::class, 'changePasswordPage'])->name('user#password');
        Route::post('password/change', [UserController::class, 'changePassword'])->name('user#change#password');

        //profile
        Route::get('profile', [UserController::class, 'profilePage'])->name('user#profile');
        Route::get('profile/edit', [UserController::class, 'profileEdit'])->name('user#profile#editPage');
        Route::post('profile/update', [UserController::class, 'profileUpdate'])->name('user#profile#update');

        //Contact route
        Route::get('contact', [ContactController::class, 'contactPage'])->name('user#contact#page');
        Route::post('contact', [ContactController::class, 'contact'])->name('user#contact');

        //Ajax Sorting Api
        Route::prefix('ajax')->group(function () {
            Route::get('sorting', [AjaxController::class, 'sorting'])->name('ajax#sorting');
            Route::get('cart', [AjaxController::class, 'cart'])->name('ajax#cart');
            Route::get('cartList', [AjaxController::class, 'orderList'])->name('ajax#orderList');
            Route::get('remove', [AjaxController::class, 'remove'])->name('ajax#remove');
            Route::get('clear', [AjaxController::class, 'clear'])->name('ajax#clear');
            Route::get('view', [AjaxController::class, 'viewCount'])->name('ajax#view');
        });
    });
});
