<?php 

use Illuminate\Support\Facades\Route;

Route::get('open-graph-image', GenerateOpenGraphImage::class)->name('open-graph-image');
Route::get('open-graph-image.jpg', GenerateOpenGraphImage::class)->name('open-graph-image-file');