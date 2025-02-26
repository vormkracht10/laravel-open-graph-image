<?php

namespace Backstage\LaravelOpenGraphImage\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;
use Backstage\LaravelOpenGraphImage\Facades\OpenGraphImage;

class LaravelOpenGraphImageController
{
    public function __invoke(Request $request): Response
    {
        if (! app()->environment('local') && ! $request->hasValidSignature()) {
            abort(403);
        }

        return OpenGraphImage::getResponse($request);
    }
}
