<?php

use Backstage\OgImage\Laravel\Http\Controllers\OgImageController;
use Illuminate\Support\Facades\Route;

if (app()->environment('local')) {
    Route::get('og-image/preview', [OgImageController::class, '__invoke'])->name('og-image.html');
}

Route::get('og-image', [OgImageController::class, '__invoke'])->name('og-image.file');
