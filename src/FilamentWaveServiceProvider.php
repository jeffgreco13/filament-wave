<?php

namespace Jeffgreco13\FilamentWave;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentWaveServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('filament-wave');
            // ->hasConfigFile()
            // ->hasViews()
            // ->hasMigration('create_filament-wave_table');
            // ->hasCommand(FilamentWaveCommand::class);
    }

    public function bootingPackage()
    {
        $migrationFileName = 'create_wave_customers_table';
        $filePath = $this->package->basePath("/../database/migrations/{$migrationFileName}.php");
        $this->publishes([
            $filePath => $this->generateMigrationName(
                $migrationFileName,
                now()->addSecond()
            ),
        ], "{$this->package->shortName()}-customers-migration");

        /*
         *
         * EVENTS & OBSERVERS
         *
         */
    }
}
