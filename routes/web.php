<?php

use Illuminate\Support\Facades\Route;
use Vormkracht10\LaravelOpenGraphImage\Http\Controllers\LaravelOpenGraphImageController;

if (config('app.env') == 'local') {
    Route::get('open-graph-image', [LaravelOpenGraphImageController::class, '__invoke'])->name('open-graph-image');
}
Route::get('open-graph-image.jpg', [LaravelOpenGraphImageController::class, '__invoke'])->name('open-graph-image-file');
