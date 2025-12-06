<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::middleware(['throttle:30,1'])->group(function () {
    Route::post('/payments', [PaymentController::class, 'store']);
    Route::post('/payments/{uuid}/process', [PaymentController::class, 'process']);
    Route::get( '/payments/{payment:uuid}', [PaymentController::class, 'show']);
});
