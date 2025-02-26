<?php

namespace Backstage\LaravelOpenGraphImage;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Backstage\LaravelOpenGraphImage\Commands\ClearCache;
use Backstage\LaravelOpenGraphImage\View\Components\OpenGraphImageComponent;

class LaravelOpenGraphImageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('og-image')
            ->hasRoute('web')
            ->hasConfigFile()
            ->hasViews()
            ->hasCommand(ClearCache::class)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->askToStarRepoOnGitHub('backstagephp/laravel-og-image');
            });
    }

    public function packageRegistered()
    {
        Blade::component('og-image', OpenGraphImageComponent::class);
    }
}
