<?php

namespace Vormkracht10\LaravelOpenGraphImage;

class OpenGraphImage
{
    public function url(...$parameters)
    {
        $parameters = collect($parameters)
            ->merge(['.'.config('open-graph-image.image.extension')]) // add image extension to url for twitter compatibility
            ->all();

        return url()
            ->signedRoute('open-graph-image.file', $parameters);
    }
}
