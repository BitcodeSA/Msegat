<?php

namespace BitcodeSa\Msegat;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use BitcodeSa\Msegat\Commands\MsegatCommand;

class MsegatServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('msegat')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_msegat_table')
            ->hasCommand(MsegatCommand::class);
    }
}
