<?php

use Illuminate\Support\Facades\Route;
use Backstage\Laravel\OgImage\Http\Controllers\Laravel\OgImageController;

if (app()->environment('local')) {
    Route::get('og-image/preview', [Laravel\OgImageController::class, '__invoke'])->name('og-image.html');
}

Route::get('og-image', [Laravel\OgImageController::class, '__invoke'])->name('og-image.file');
