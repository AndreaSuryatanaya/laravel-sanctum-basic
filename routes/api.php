<?php

use App\Http\Controllers\productController;
use App\Http\Controllers\authController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return response()->json([
        'status' => false,
        'message' => 'Akses ditolak, silahkan login terlebih dahulu',
    ], 401);
})->name('login');

Route::get('product', [productController::class, 'index'])->middleware('auth:sanctum');
Route::post('registerUser', [authController::class, 'registerUser']);
Route::post('loginUser', [authController::class, 'loginUser']);
