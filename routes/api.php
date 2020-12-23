<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeatsController;

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

Route::prefix('v1')->group(function () {
    Route::post('/flights/1/seats/book', [SeatsController::class, 'book']);
    Route::get('/flights/1/seats/book', [SeatsController::class, 'book']);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
