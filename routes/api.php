<?php

use App\Http\Controllers\AdminPanel\ConfigController;
use App\Http\Controllers\Api\V1\DateController;
use App\Http\Controllers\Api\V1\TimeEstimationController;
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




Route::group(['prefix' => 'v1'], function () {

    Route::get('configs', [ConfigController::class, 'getRoutes'])->name('configs.index');

    Route::get('estimate-delivery-time', [TimeEstimationController::class, 'estimateDeliveryTime'])->name('time-estimation');

    Route::get('/convert-timestamp', [DateController::class, 'getDaysFromSpecificDate'])->name('next-days');
    Route::get('/check-time-overlap', [DateController::class, 'checkTimeOverlap'])->name('check-time-overlap');

});

