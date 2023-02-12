<?php

use Illuminate\Support\Facades\Route;
use Vormkracht10\LaravelOpenGraphImage\Http\Controllers\LaravelOpenGraphImageController;

if (app()->environment('local')) {
    Route::get('open-graph-image/preview', [LaravelOpenGraphImageController::class, '__invoke'])->name('open-graph-image.html');
}

Route::get('open-graph-image', [LaravelOpenGraphImageController::class, '__invoke'])->name('open-graph-image.file');
