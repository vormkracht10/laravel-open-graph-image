<?php

use Vormkracht10\LaravelOpenGraphImage\Facades\OpenGraphImage;

it('can generate an image using params', function () {
    $image = OpenGraphImage::createImageFromParams([
        'title' => 'title',
        'description' => 'description',
    ]);

    expect($image)->toBeString();
});

