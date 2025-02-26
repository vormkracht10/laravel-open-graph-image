<?php

use Backstage\Laravel\OgImage\Facades\OgImage;

it('can generate an image using params', function () {

    $this->markTestSkipped('Pest is not configured correctly yet.');

    $image = OgImage::createImageFromParams([
        'title' => 'title',
        'description' => 'description',
    ]);

    expect($image)->toBeString();
});
