<?php

use Backstage\LaravelOpenGraphImage\Facades\OpenGraphImage;

it('can generate an image using params', function () {

    $this->markTestSkipped('Pest is not configured correctly yet.');

    $image = OpenGraphImage::createImageFromParams([
        'title' => 'title',
        'description' => 'description',
    ]);

    expect($image)->toBeString();
});
