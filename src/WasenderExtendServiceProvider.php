<?php

namespace Alareqi\WasenderExtend;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Alareqi\WasenderExtend\Commands\WasenderExtendCommand;

class WasenderExtendServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('wasender-extend')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_wasender_extend_table');
    }
}
