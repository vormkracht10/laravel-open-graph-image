<?php

namespace Backstage\LaravelOpenGraphImage\View\Components;

use Closure;
use Illuminate\View\Component;
use Backstage\LaravelOpenGraphImage\Facades\OpenGraphImage;

class OpenGraphImageComponent extends Component
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
        $signature = OpenGraphImage::getSignature($data['attributes']);

        OpenGraphImage::ensureDirectoryExists('views');

        if (
            trim((string) $data['slot']) === '' ||
            $this->getSlotHash($data['slot']) !== $this->getCachedSlotHash($signature)
        ) {
            OpenGraphImage::getStorageDisk()->put(
                OpenGraphImage::getStorageViewFilePath($signature), $data['slot']
            );
        }
    }

    public function getCachedSlotHash(string $signature): ?string
    {
        return OpenGraphImage::getStorageViewFileData($signature);
    }

    public function getSlotHash($slot): string
    {
        return md5($slot);
    }
}
