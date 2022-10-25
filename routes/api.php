<?php

use App\Http\Controllers\ApiV1\FileController;
use App\Http\Controllers\ApiV1\MarathonController;
use Illuminate\Support\Facades\Route;

Route::middleware('check.token')->group(function () {
    // Marathon routes
    Route::apiResource('marathons', MarathonController::class);

    // File routes
    Route::post('/files/upload', [FileController::class, 'upload']);
    Route::get('/files/{model}/{folder}/{filename}', [FileController::class, 'file']);
    Route::get('/files/image/{model}/{folder}/{filename}/{width}/{height}', [FileController::class, 'image']);
});