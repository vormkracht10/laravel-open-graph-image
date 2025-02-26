<?php

namespace Backstage\LaravelOpenGraphImage\Facades;

use Illuminate\Support\Facades\Facade;

class OpenGraphImage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Backstage\LaravelOpenGraphImage\OpenGraphImage::class;
    }
}
