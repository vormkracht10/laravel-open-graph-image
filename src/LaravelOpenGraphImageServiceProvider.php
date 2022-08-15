<?php

namespace Vormkracht10\LaravelOpenGraphImage;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Vormkracht10\LaravelOpenGraphImage\Commands\LaravelOpenGraphImageCommand;

class LaravelOpenGraphImageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-open-graph-image')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-open-graph-image_table')
            ->hasCommand(LaravelOpenGraphImageCommand::class);
    }
}
