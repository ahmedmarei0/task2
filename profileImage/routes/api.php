<?php

use App\Http\Controllers\ImageController;
use App\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::middleware(EnsureTokenIsValid::class)->group(function () {
    Route::post('/upload', [ImageController::class, 'upload']);
    Route::get('user/images', [ImageController::class, 'getUserImage']);
});

Route::post('user/test', [ImageController::class, 'testData'])->middleware('auth');


