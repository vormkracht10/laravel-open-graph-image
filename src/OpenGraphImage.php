<?php

namespace Vormkracht10\LaravelOpenGraphImage;

use Illuminate\View\ComponentAttributeBag;

class OpenGraphImage
{
    public function transformAttributeBagToArray(ComponentAttributeBag $attributes): array
    {
        return collect($attributes)->all();
    }

    public function url(array|ComponentAttributeBag $parameters): string
    {
        if ($parameters instanceof ComponentAttributeBag) {
            $parameters = $this->transformAttributeBagToArray($parameters);
        }

        $parameters = collect($parameters)
            ->merge(['.'.config('open-graph-image.image.extension')]) // add image extension to url for twitter compatibility
            ->all();

        return url()
            ->signedRoute('open-graph-image.file', $parameters);
    }
}
