<?php

namespace Vormkracht10\LaravelOpenGraphImage\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Vormkracht10\LaravelOpenGraphImage\LaravelOpenGraphImage
 */
class LaravelOpenGraphImage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Vormkracht10\LaravelOpenGraphImage\LaravelOpenGraphImage::class;
    }
}
