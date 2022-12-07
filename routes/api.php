<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('products', [ApiController::class, 'products']);

Route::get('contacts', [ApiController::class, 'contacts']);
Route::post('contact', [ApiController::class, 'contact']);
Route::post('contact/delete', [ApiController::class, 'delete']);
Route::post('contact/update', [ApiController::class, 'update']);

/*

http://127.0.0.1:8000/api/products  (GET Products)

http://127.0.0.1:8000/api/contact (POST Contact)


*/
