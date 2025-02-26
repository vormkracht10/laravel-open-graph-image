<?php

namespace Backstage\Laravel\OgImage\Facades;

use Illuminate\Support\Facades\Facade;

class OgImage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Backstage\Laravel\OgImage\OgImage::class;
    }
}
