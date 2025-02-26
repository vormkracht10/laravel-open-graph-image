<?php

namespace Backstage\OgImage\Laravel\View\Components;

use Closure;
use Illuminate\View\Component;
use Backstage\OgImage\Laravel\Facades\OgImage;

class OgImageComponent extends Component
{
    public function render(): Closure
    {
        $metatags = view('og-image::metatags');

        return function (array $data) use ($metatags) {
            $this->updateAndCacheSlotView($data);

            return $metatags;
        };
    }

    public function updateAndCacheSlotView($data)
    {
        $signature = OgImage::getSignature($data['attributes']);

        OgImage::ensureDirectoryExists('views');

        if (
            trim((string) $data['slot']) === '' ||
            $this->getSlotHash($data['slot']) !== $this->getCachedSlotHash($signature)
        ) {
            OgImage::getStorageDisk()->put(
                OgImage::getStorageViewFilePath($signature), $data['slot']
            );
        }
    }

    public function getCachedSlotHash(string $signature): ?string
    {
        return OgImage::getStorageViewFileData($signature);
    }

    public function getSlotHash($slot): string
    {
        return md5($slot);
    }
}
