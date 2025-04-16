<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminPanel\LoadsController;
use App\Http\Controllers\AdminPanel\EstimateController;


// admin panel route's
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {


    // loads route's
    Route::resource('loads', LoadsController::class);
    Route::get('loads/delete/{number?}', [LoadsController::class, 'delete'])->name('loads.delete');

    // estimate route's
    Route::get('estimate/', [EstimateController::class, 'estimate'])->name('estimate');
    Route::get('estimate/index', [EstimateController::class, 'index'])->name('estimate.index');
    Route::post('estimate', [EstimateController::class, 'store'])->name('estimate.store');
    Route::get('estimate/{estimate}', [EstimateController::class, 'show'])->name('estimate.show');
    Route::get('estimates/data', [EstimateController::class, 'getData'])->name('estimates.data');
    Route::delete('estimate/{estimate}', [EstimateController::class, 'destroy'])->name('estimate.destroy');
    Route::delete('estimate/reject/{estimate}', [EstimateController::class, 'reject'])->name('estimate.reject');


});

