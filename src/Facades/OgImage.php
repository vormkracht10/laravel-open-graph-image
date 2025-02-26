<?php

namespace Backstage\OgImage\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class OgImage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Backstage\OgImage\Laravel\OgImage::class;
    }
}
