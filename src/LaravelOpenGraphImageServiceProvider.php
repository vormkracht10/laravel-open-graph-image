<?php

namespace Vormkracht10\LaravelOpenGraphImage;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
