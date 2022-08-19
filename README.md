# Generate dynamic Open Graph images

[![Latest Version on Packagist](https://img.shields.io/packagist/v/vormkracht10/laravel-open-graph-image.svg?style=flat-square)](https://packagist.org/packages/vormkracht10/laravel-open-graph-image)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/vormkracht10/laravel-open-graph-image/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/vormkracht10/laravel-open-graph-image/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/vormkracht10/laravel-open-graph-image.svg?style=flat-square)](https://packagist.org/packages/vormkracht10/laravel-open-graph-image)

This Laravel package enables you to dynamically create Open Graph images for your website. Just add the meta tag with our url to the head of your page.  The package will then generate the image and add it to the page. You can edit the view template which you can find in the resources folder.

## Installation

You can install the package via composer:

```bash
composer require vormkracht10/laravel-open-graph-image
```

You can publish the views using

```bash
php artisan vendor:publish --tag="open-graph-image-views"
```

You can publish the assets using

```bash
php artisan vendor:publish --tag="open-graph-image-assets"
```

## Usage

Just add the following meta tag to your page.

```html
<meta property="og:image" content="{!! url()->signedRoute('open-graph-image', ['title' => 'Test']) !!}">
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/vormkracht10/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Bas van Dinther](https://github.com/baspa)
- [Mark van Eijk](https://github.com/markvaneijk)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
