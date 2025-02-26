<?php

use Backstage\Laravel\OgImage\Facades\OgImage;

if (! function_exists('og')) {
    function og(...$args): string
    {
        return OgImage::url(...$args);
    }
}
