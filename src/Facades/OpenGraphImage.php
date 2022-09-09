<?php

namespace Vormkracht10\LaravelOpenGraphImage\Facades;

use Illuminate\Support\Facades\Facade;

class OpenGraphImage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Vormkracht10\LaravelOpenGraphImage\OpenGraphImage::class;
    }
}
