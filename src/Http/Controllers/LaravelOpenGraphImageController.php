<?php

namespace Vormkracht10\LaravelOpenGraphImage\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

class LaravelOpenGraphImageController
{
    public function __invoke(Request $request)
    {
        if (! app()->environment('local') && ! $request->hasValidSignature()) {
            abort(403);
        }

        $title = $request->title ?? config('app.name');
        $filename = Str::slug($title).'.jpg';

        $html = view('vendor.open-graph-image.template', compact('title'));

        if ($request->route()->getName() == 'open-graph-image') {
            return $html;
        }

        if (! Storage::disk('public')->exists('social/open-graph/'.$filename)) {
            $this->saveOpenGraphImage($html, $filename);
        }

        return $this->getOpenGraphImageResponse($filename);
    }

    public function saveOpenGraphImage($html, $filename)
    {
        $path = Storage::disk('public')
            ->path('social/open-graph/'.$filename);

        Browsershot::html($html)
            ->showBackground()
            ->windowSize(1200, 630)
            ->setScreenshotType('jpeg', 100)
            ->save($path);
    }

    public function getOpenGraphImageResponse($filename)
    {
        return response(
            Storage::disk('public')->get('social/open-graph/'.$filename), 200, [
                'Content-Type' => 'image/jpeg',
            ]);
    }
}
