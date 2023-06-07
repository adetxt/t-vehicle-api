<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'middleware' => ['api', 'rest'],
], function () {
    Route::apiResource('vehicles', VehicleController::class);
    Route::apiResource('sales', SaleController::class)->except('update');
    Route::get('report/all', [ReportController::class, 'allVehicles']);

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, "login"]);
        Route::post('register', [AuthController::class, "register"]);
        Route::post('logout', [AuthController::class, "logout"]);
        Route::post('me', [AuthController::class, "me"]);
    });
});
