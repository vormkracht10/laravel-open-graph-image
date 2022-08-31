<?php

namespace Vormkracht10\LaravelOpenGraphImage;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Vormkracht10\LaravelOpenGraphImage\Components\LaravelOpenGraphImage;

class LaravelOpenGraphImageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-open-graph-image')
            ->hasRoute('web')
            ->hasConfigFile()
            ->hasViewComponent('laravel-open-graph-image', LaravelOpenGraphImage::class)
            ->hasViews();

        Blade::component('open-graph-image', LaravelOpenGraphImage::class);
    }
}
