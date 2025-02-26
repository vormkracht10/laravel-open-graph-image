<?php

namespace Backstage\Laravel\OgImage\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;
use Backstage\Laravel\OgImage\Facades\OgImage;

class Laravel\OgImageController
{
    public function __invoke(Request $request): Response
    {
        if (! app()->environment('local') && ! $request->hasValidSignature()) {
            abort(403);
        }

        return OgImage::getResponse($request);
    }
}
