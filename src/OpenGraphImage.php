<?php

namespace Vormkracht10\LaravelOpenGraphImage;

use Illuminate\Support\Facades\Storage;
use Illuminate\View\ComponentAttributeBag;
use Vormkracht10\LaravelOpenGraphImage\Http\Controllers\LaravelOpenGraphImageController;
use Illuminate\Support\Facades\View;

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

    public function createImageFromParams(array $params): string
    {
        $url = $this->url($params);

        $url = parse_url($url);

        parse_str($url['query'], $params);

        $signature = $params['signature'];

        $imageController = new LaravelOpenGraphImageController;

        if (! $imageController->getStorageFileExists($signature)) {
            $html = View::make('open-graph-image::template', $params)
                ->render();

            $imageController->saveOpenGraphImage($html, $signature);
        }

        return Storage::disk(config('open-graph-image.storage.disk'))
            ->get($imageController->getStorageFilePath($signature));
    }
}
