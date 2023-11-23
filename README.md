# FilamentWave

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffgreco13/filament-wave.svg?style=flat-square)](https://packagist.org/packages/jeffgreco13/filament-wave)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jeffgreco13/filament-wave/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/jeffgreco13/filament-wave/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffgreco13/filament-wave/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/jeffgreco13/filament-wave/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffgreco13/filament-wave.svg?style=flat-square)](https://packagist.org/packages/jeffgreco13/filament-wave)

A Filament V3 plugin to create robust integrations for Wave Apps/Accounting.

## Expert Support

Looking for a custom integration or solution? Contact me jeff@jeffpgreco.com

## Installation

You can install the package via composer:

```bash
composer require jeffgreco13/filament-wave
```

Update your .env file to include:

```
WAVE_ACCESS_TOKEN= *your full access token*
WAVE_BUSINESS_ID= *ID for the business you wish to interact with*
WAVE_GRAPHQL_URI= *defaults to https://gql.waveapps.com/graphql/public*
```
This package uses [jeffgreco13/laravel-wave][laravel-wave] under the hood. Review the docs for more information.

Add the `WavePlugin` to your panel service provider:

```php
use Jeffgreco13\FilamentWave\WavePlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ...
            ->plugin(
                WavePlugin::make()
            );
    }
}
```

## Usage

I've build this package to be as modular and extensible as possible. Meaning you can publish migrations and utilize Filament resources only as needed. See below on how to use each model:

### Customers

Publish the customers migration table using.

```bash
php artisan vendor:publish --tag="filament-wave-customers-migration"
php artisan migrate
```

Next, add the `customers` method to the WavePlugin in your panel service provider:

```php
WavePlugin::make()->customers()
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jeff Greco](https://github.com/jeffgreco13)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[laravel-wave]: https://github.com/jeffgreco13/laravel-wave
