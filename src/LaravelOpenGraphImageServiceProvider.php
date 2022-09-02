<?php

namespace Vormkracht10\LaravelOpenGraphImage;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Vormkracht10\LaravelOpenGraphImage\Components\OpenGraphImage;

class LaravelOpenGraphImageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('open-graph-image')
            ->hasRoute('web')
            ->hasConfigFile()
            ->hasViews();
    }
}
