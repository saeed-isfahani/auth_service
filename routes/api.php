<?php

use App\Http\Controllers\AuthController;
use Carbon\Carbon;
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

Route::prefix('v1')->middleware(['throttle:20,1'])->group(function () {
    Route::group([
        'middleware' => 'api',
    ], function ($router) {
        Route::post('login', [AuthController::class, 'login'])->name('auth.login');
        Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('check-token', [AuthController::class, 'checkToken'])->name('auth.check_token');
    });
    Route::get('check-health', function () {
        return response()->json(['data' => ['message' => 'Service is working properly.'], 'server_time' => Carbon::now()]);
    });
});
