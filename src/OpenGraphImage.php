<?php

namespace Backstage\LaravelOpenGraphImage;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\ComponentAttributeBag;
use Illuminate\Filesystem\FilesystemAdapter;

class OpenGraphImage
{
    public function imageExtension()
    {
        return config('og-image.image.extension');
    }

    public function imageQuality()
    {
        return config('og-image.image.quality');
    }

    public function imageWidth()
    {
        return config('og-image.image.width');
    }

    public function imageHeight()
    {
        return config('og-image.image.height');
    }

    public function storageDisk()
    {
        return config('og-image.storage.disk');
    }

    public function storagePath($folder = null)
    {
        return rtrim(config('og-image.storage.path')).($folder ? '/'.$folder : '');
    }

    public function method()
    {
        return config('og-image.method');
    }

    public function getStorageDisk(): FilesystemAdapter
    {
        return Storage::disk($this->storageDisk());
    }

    public function getStoragePath($folder = null)
    {
        return rtrim($this->storagePath($folder), '/');
    }

    public function getStorageImageFileName($signature)
    {
        return $signature.'.'.$this->imageExtension();
    }

    public function getStorageImageFilePath($signature)
    {
        return $this->getStoragePath('images').'/'.$this->getStorageImageFileName($signature);
    }

    public function getStorageImageFileExists($signature)
    {
        return $this->getStorageDisk()
            ->exists($this->getStorageImageFilePath($signature));
    }

    public function getStorageImageFileData($signature)
    {
        return $this->getStorageDisk()
            ->get($this->getStorageImageFilePath($signature));
    }

    public function getStorageViewFileName($signature)
    {
        return $signature.'.blade.php';
    }

    public function getStorageViewFilePath($signature, $folder = null)
    {
        return $this->getStoragePath('views').'/'.$this->getStorageViewFileName($signature);
    }

    public function getStorageViewFileData($signature)
    {
        return $this->getStorageDisk()
            ->get($this->getStorageViewFilePath($signature));
    }

    public function getStorageViewFileExists($signature)
    {
        return $this->getStorageDisk()
            ->exists($this->getStorageViewFilePath($signature));
    }

    public function getImageMimeType()
    {
        return match ($this->imageExtension()) {
            'jpg' => 'image/jpeg',
            default => 'image/'.$this->imageExtension(),
        };
    }

    public function ensureDirectoryExists($folder = '')
    {
        if (! File::isDirectory($this->getStoragePath($folder))) {
            File::makeDirectory($this->getStoragePath($folder), 0777, true);
        }
    }

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
            ->merge(['.'.config('og-image.image.extension')]) // add image extension to url for twitter compatibility
            ->all();

        return url()
            ->signedRoute('og-image.file', $parameters);
    }

    public function getSignature(array|ComponentAttributeBag $parameters): string
    {
        if ($parameters instanceof ComponentAttributeBag) {
            $parameters = $this->transformAttributeBagToArray($parameters);
        }

        $url = $this->url($parameters);

        $url = parse_url($url);

        parse_str($url['query'], $parameters);

        return $parameters['signature'];
    }

    public function createImageFromParams(array $parameters): ?string
    {
        $signature = $this->getSignature($parameters);

        if (! OpenGraphImage::getStorageImageFileExists($signature)) {
            $html = View::make('og-image::template', $parameters)
                ->render();

            OpenGraphImage::saveImage($html, $signature);
        }

        return Storage::disk(config('og-image.storage.disk'))
            ->get(OpenGraphImage::getStorageImageFilePath($signature));
    }

    public function saveImage(string $html, string $filename): void
    {
        if (OpenGraphImage::getStorageImageFileExists($filename)) {
            return;
        }

        OpenGraphImage::ensureDirectoryExists('images');

        $screenshot = $this->getScreenshot($html, $filename);

        OpenGraphImage::getStorageDisk()
            ->put(OpenGraphImage::getStorageImageFilePath($filename), $screenshot);
    }

    public function getScreenshot(string $html, string $filename): string
    {
        $browsershot = Browsershot::html($html)
            ->noSandbox()
            ->showBackground()
            ->windowSize(OpenGraphImage::imageWidth(), OpenGraphImage::imageHeight())
            ->setScreenshotType(OpenGraphImage::getImageMimeType(), OpenGraphImage::imageQuality());

        if (config('og-image.paths.node')) {
            $browsershot = $browsershot->setNodeBinary(config('og-image.paths.node'));
        }

        if (config('og-image.paths.npm')) {
            $browsershot = $browsershot->setNpmBinary(config('og-image.paths.npm'));
        }

        return $browsershot->screenshot(OpenGraphImage::getStorageImageFilePath($filename));
    }

    public function getResponse(Request $request): Response
    {
        $this->generateImage($request);

        return response(OpenGraphImage::getStorageImageFileData($request->signature), 200, [
            'Content-Type' => 'image/'.OpenGraphImage::getImageMimeType(),
        ]);
    }

    public function generateImage($request)
    {
        if($request->view && view()->exists($request->view)) {
            $html = View::make($request->view, $request->all())
                ->render();
        } else if(OpenGraphImage::getStorageViewFileExists($request->signature)) {
            $html = OpenGraphImage::getStorageViewFileData($request->signature);
        }
        else {
            $html = View::make('og-image::template', $request->all())
                ->render();
        }

        if ($request->route()->getName() == 'og-image') {
            return $html;
        }

        OpenGraphImage::saveImage($html, $request->signature);
    }
}
