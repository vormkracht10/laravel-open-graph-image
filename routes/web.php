<?php 

use Illuminate\Support\Facades\Route;
use Vormkracht10\LaravelOpenGraphImage\Http\Controllers\LaravelOpenGraphImageController;

Route::get('open-graph-image', [LaravelOpenGraphImageController::class, '__invoke'])->name('open-graph-image');

// Route::get('open-graph-image', [LaravelOpenGraphImageController::class])->name('open-graph-image');
// Route::get('open-graph-image.jpg', [LaravelOpenGraphController::class])->name('open-graph-image-file');