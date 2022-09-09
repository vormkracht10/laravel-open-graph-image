<?php

namespace Vormkracht10\LaravelOpenGraphImage;

class OpenGraphImage
{
    public function url(...$args)
    {
        return url()->signedRoute('open-graph-image.file', ...$args);
    }
}
