<?php

namespace Vormkracht10\LaravelOpenGraphImage\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;

class LaravelOpenGraphController
{
    public function __invoke(Request $request)
    {
        if(! app()->environment('local') && ! $request->hasValidSignature()) {
            abort(403);
        }

        $title = $request->title ?? config('app.name');
        $filename = str_slug($title).'.jpg';

        $html = view('open-graph-image.template', compact('title'));

        if($request->route()->getName() == 'open-graph-image') {
            return $html;
        }

        if(! Storage::disk('public')->exists('social/open-graph/'.$filename)) {
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
