<?php

use Illuminate\Support\Facades\Route;

Route::middleware('check.token')->group(function () {
    // File routes
    Route::post('/files/upload', [\App\Http\Controllers\ApiV1\FileController::class, 'upload']);
    Route::get('/files/{model}/{folder}/{filename}', [\App\Http\Controllers\ApiV1\FileController::class, 'file']);
    Route::get('/files/image/{model}/{folder}/{filename}/{width}/{height}', [\App\Http\Controllers\ApiV1\FileController::class, 'image']);
});
