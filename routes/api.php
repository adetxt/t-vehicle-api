<?php

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
});
