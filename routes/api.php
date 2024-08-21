<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/

Route::group([
    'prefix' => 'paymentbooklet'
], function ($router) {
    // Basic CRUD.
    /*Route::post('/', [MaintenanceController::class, 'store'])->middleware('auth:api')->name('maintenances.store');
    Route::get('/', [MaintenanceController::class, 'index'])->middleware('auth:api')->name('maintenances.index');
    Route::get('/{id}', [MaintenanceController::class, 'show'])->middleware('auth:api')->name('maintenances.show');
    Route::put('/{id}', [MaintenanceController::class, 'update'])->middleware('auth:api')->name('maintenances.update');
    Route::delete('/{id}', [MaintenanceController::class, 'destroy'])->middleware('auth:api')->name('maintenances.destroy');*/

    Route::post('/', [PaymentController::class, 'store'])->middleware('api')->name('store');
    Route::get('/{id}', [PaymentController::class, 'show'])->middleware('api')->name('show');

});
