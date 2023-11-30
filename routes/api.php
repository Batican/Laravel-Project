<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [AuthenticationController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('me', [AuthenticationController::class, 'me']);
    Route::post('logout', [AuthenticationController::class, 'logout']);

    Route::resource('users', UserController::class);
    Route::get('users-get-all', [UserController::class, 'getAll']);
    Route::patch('users/assign-role/{user}', [UserController::class, 'assignRole']);
    Route::resource('products', ProductController::class);
    Route::get('products-get-all', [ProductController::class, 'getAll']);
});
