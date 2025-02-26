<?php

namespace Backstage\OgImage\Laravel\Http\Controllers;

use Backstage\OgImage\Laravel\Facades\OgImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
