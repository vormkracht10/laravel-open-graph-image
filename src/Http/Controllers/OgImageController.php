<?php

namespace Backstage\OgImage\Laravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;
use Backstage\OgImage\Laravel\Facades\OgImage;

class OgImageController
{
    public function __invoke(Request $request): Response
    {
        if (! app()->environment('local') && ! $request->hasValidSignature()) {
            abort(403);
        }

        return OgImage::getResponse($request);
    }
}
