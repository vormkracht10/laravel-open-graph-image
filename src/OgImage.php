<?php

namespace Backstage\OgImage\Laravel;

use HeadlessChromium\BrowserFactory;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\View\ComponentAttributeBag;

class OgImage
{
    public function imageExtension(): string
    {
        return config('og-image.extension');
    }

    public function imageQuality(): int
    {
        return config('og-image.quality');
    }

    public function imageWidth(): int
    {
        return config('og-image.width');
    }

    public function imageHeight(): int
    {
        return config('og-image.height');
    }

    public function storageDisk(): string
    {
        return config('og-image.storage.disk');
    }

    public function storagePath($folder = null): string
    {
        return rtrim(config('og-image.storage.path')).($folder ? '/'.$folder : '');
    }

    public function method(): string
    {
        return config('og-image.method');
    }

    public function getStorageDisk(): FilesystemAdapter
    {
        return Storage::disk($this->storageDisk());
    }

    public function getStoragePath(?string $folder = null): string
    {
        return rtrim($this->storagePath($folder), '/');
    }

    public function getStorageImageFileName(string $signature): string
    {
        return $signature.'.'.$this->imageExtension();
    }

    public function getStorageImageFilePath(string $signature): string
    {
        return $this->getStoragePath('images').'/'.$this->getStorageImageFileName($signature);
    }

    public function getStorageImageFileExists(string $signature): string
    {
        return $this->getStorageDisk()
            ->exists($this->getStorageImageFilePath($signature));
    }

    public function getStorageImageFileData(string $signature): string
    {
        return $this->getStorageDisk()
            ->get($this->getStorageImageFilePath($signature));
    }

    public function getStorageViewFileName(string $signature): string
    {
        return $signature.'.blade.php';
    }

    public function getStorageViewFilePath(string $signature, ?string $folder = null): string
    {
        return $this->getStoragePath('views').'/'.$this->getStorageViewFileName($signature);
    }

    public function getStorageViewFileData(string $signature): string
    {
        return $this->getStorageDisk()
            ->get($this->getStorageViewFilePath($signature));
    }

    public function getStorageViewFileExists(string $signature): bool
    {
        return $this->getStorageDisk()
            ->exists($this->getStorageViewFilePath($signature));
    }

    public function ensureDirectoryExists(string $folder = ''): string
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
            ->merge(['.'.config('og-image.extension')]) // add image extension to url for twitter compatibility
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

        if (! OgImage::getStorageImageFileExists($signature)) {
            $html = View::make('og-image::template', $parameters)
                ->render();

            OgImage::saveImage($html, $signature);
        }

        return Storage::disk(config('og-image.storage.disk'))
            ->get(OgImage::getStorageImageFilePath($signature));
    }

    public function saveImage(string $html, string $filename): void
    {
        if (OgImage::getStorageImageFileExists($filename)) {
            return;
        }

        OgImage::ensureDirectoryExists('images');

        $screenshot = $this->getScreenshot($html, $filename);

        OgImage::getStorageDisk()
            ->put(OgImage::getStorageImageFilePath($filename), $screenshot);
    }

    public function getScreenshot(string $html, string $filename): string
    {
        $binary = (string) config('og-image.chrome.binary');

        $browser = (new BrowserFactory($binary))
            ->createBrowser([
                'noSandbox' => true,
                'ignoreCertificateErrors' => true,
                'customFlags' => config('og-image.chrome.flags'),
            ]);
        
        $screenshot =$browser->createPage()
            ->setHtml($html, eventName: 'og-image')
            ->evaluate($this->injectJs())
            ->setViewport(OgImage::imageWidth(), OgImage::imageHeight())
            ->screenshot();

        $browser->close();

        dd($screenshot);
    }

    private function injectJs(): string
    {
        // Wait until all images and fonts have loaded
        // Taken from: https://github.com/svycal/og-image/blob/main/priv/js/take-screenshot.js#L42C5-L63
        // See: https://github.blog/2021-06-22-framework-building-open-graph-images/#some-performance-gotchas

        return <<<'JS'
            const selectors = Array.from(document.querySelectorAll('img'));

            await Promise.all([
                document.fonts.ready,
                    ...selectors.map((img) => {
                        // Image has already finished loading, let’s see if it worked

                        if (img.complete) {
                            // Image loaded and has presence
                            if (img.naturalHeight !== 0) return;
                        
                            // Image failed, so it has no height
                            throw new Error("Image failed to load");
                        }

                        // Image hasn’t loaded yet, added an event listener to know when it does
                        return new Promise((resolve, reject) => {
                            img.addEventListener("load", resolve);
                            img.addEventListener("error", reject);
                        });
                    })
                ]);
        JS;
    }

    public function getResponse(Request $request): Response
    {
        $this->generateImage($request);

        return response(OgImage::getStorageImageFileData($request->signature), 200, [
            'Content-Type' => 'image/'.OgImage::getImageMimeType(),
        ]);
    }

    public function generateImage($request)
    {
        if ($request->view && view()->exists($request->view)) {
            $html = View::make($request->view, $request->all())
                ->render();
        } elseif (OgImage::getStorageViewFileExists($request->signature)) {
            $html = OgImage::getStorageViewFileData($request->signature);
        } else {
            $html = View::make('og-image::template', $request->all())
                ->render();
        }

        if ($request->route()->getName() == 'og-image') {
            return $html;
        }

        OgImage::saveImage($html, $request->signature);
    }
}
