<?php

use Illuminate\Support\Facades\Route;
use Backstage\LaravelOpenGraphImage\Http\Controllers\LaravelOpenGraphImageController;

if (app()->environment('local')) {
    Route::get('og-image/preview', [LaravelOpenGraphImageController::class, '__invoke'])->name('og-image.html');
}

Route::get('og-image', [LaravelOpenGraphImageController::class, '__invoke'])->name('og-image.file');
