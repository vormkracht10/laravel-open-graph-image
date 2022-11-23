<?php

namespace Vormkracht10\LaravelOpenGraphImage\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;

class LaravelOpenGraphImageController
{
    protected $imageExtension;

    protected $imageQuality;

    protected $imageWidth;

    protected $imageHeight;

    protected $storageDisk;

    protected $storagePath;

    protected $method;

    public function __construct()
    {
        $this->imageExtension = config('open-graph-image.image.extension');
        $this->imageQuality = config('open-graph-image.image.quality');
        $this->imageWidth = config('open-graph-image.image.width');
        $this->imageHeight = config('open-graph-image.image.height');
        $this->storageDisk = config('open-graph-image.storage.disk');
        $this->storagePath = config('open-graph-image.storage.path');
        $this->method = config('open-graph-image.method');
    }

    public function __invoke(Request $request)
    {
        if (! app()->environment('local') && ! $request->hasValidSignature()) {
            abort(403);
        }

        $html = View::make('open-graph-image::template', $request->all())
            ->render();

        if ($request->route()->getName() == 'open-graph-image') {
            return $html;
        }

        if (! $this->getStorageFileExists($request->signature)) {
            $this->saveOpenGraphImage($html, $request->signature);
        }

        return $this->getOpenGraphImageResponse($request->signature);
    }

    public function getStorageDisk()
    {
        return Storage::disk($this->storageDisk);
    }

    public function getStoragePath()
    {
        return rtrim($this->storagePath, '/');
    }

    public function getStorageFileName($signature)
    {
        return $signature.'.'.$this->imageExtension;
    }

    public function getStorageFilePath($filename)
    {
        return $this->getStoragePath().'/'.$this->getStorageFileName($filename);
    }

    public function getStorageFileData($filename)
    {
        return $this->getStorageDisk()
            ->get($this->getStorageFilePath($filename));
    }

    public function getStorageFileExists($filename)
    {
        return $this->getStorageDisk()
            ->exists($this->getStorageFilePath($filename));
    }

    public function getImageType()
    {
        return match ($this->imageExtension) {
            'jpg' => 'jpeg',
            default => $this->imageExtension,
        };
    }

    public function ensureDirectoryExists()
    {
        if (! File::isDirectory($this->getStoragePath())) {
            File::makeDirectory($this->getStoragePath(), 0777, true);
        }
    }

    public function getScreenshot($html, $filename)
    {
        return Browsershot::html($html)
            ->noSandbox()
            ->showBackground()
            ->windowSize($this->imageWidth, $this->imageHeight)
            ->setScreenshotType($this->getImageType(), $this->imageQuality)
            ->screenshot($this->getStorageFilePath($filename));
    }

    public function saveOpenGraphImage($html, $filename)
    {
        $this->ensureDirectoryExists();

        $screenshot = $this->getScreenshot($html, $filename);

        $this->getStorageDisk()
            ->put($this->getStorageFilePath($filename), $screenshot);
    }

    public function getOpenGraphImageResponse($filename)
    {
        return response($this->getStorageFileData($filename), 200, [
            'Content-Type' => 'image/'.$this->getImageType(),
        ]);
    }
}
