<?php

use Backstage\LaravelOpenGraphImage\Facades\OpenGraphImage;

if (! function_exists('og')) {
    function og(...$args): string
    {
        return OpenGraphImage::url(...$args);
    }
}
