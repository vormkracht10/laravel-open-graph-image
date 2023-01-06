# Generate Dynamic Open Graph Images in Laravel

![GitHub release (latest by date)](https://img.shields.io/github/v/release/vormkracht10/laravel-open-graph-image)
[![Tests](https://github.com/vormkracht10/laravel-open-graph-image/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/vormkracht10/laravel-open-graph-image/actions/workflows/run-tests.yml)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/vormkracht10/laravel-open-graph-image)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/vormkracht10/laravel-open-graph-image.svg?style=flat-square)](https://packagist.org/packages/vormkracht10/laravel-open-graph-image)
[![Total Downloads](https://img.shields.io/packagist/dt/vormkracht10/laravel-open-graph-image.svg?style=flat-square)](https://packagist.org/packages/vormkracht10/laravel-open-graph-image)

This Laravel package enables you to dynamically create Open Graph images for your website based on a single Blade template with HTML and CSS. In our example we use the Tailwind CDN. So designing a dynamic Open Graph Image as a developer just got very easy using this package!

Just add the meta tag with our url to the head of your page. The package will then generate the image and add it to the page. You can edit the view template which you can find in the resources folder.

-   [Requirements](#requirements)
-   [Installation](#installation)
-   [Usage](#usage)
    -   [Passing extra attributes](#passing-extra-attributes)
    -   [Clearing cached images](#clearing-cached-images)
-   [Changelog](#changelog)
-   [Contributing](#contributing)
-   [Security Vulnerabilities](#security-vulnerabilities)
-   [Credits](#credits)
-   [License](#license)

## Requirements

<ul>
  <li>PHP 8.1+</li>
</ul>

## Installation

You can install the package via composer:

```bash
composer require vormkracht10/laravel-open-graph-image
```

Then you should install puppeteer:

```bash
npm install puppeteer
```

Run the command to install the package:

```bash
php artisan open-graph-image:install
```

You should also publish the views:

```bash
php artisan vendor:publish --tag="open-graph-image-views"
```

This is the content of the published config file (published at `config/open-graph-image.php`):

```php
return [
    'image' => [
        'extension' => 'jpg',
        'quality' => 100,
        'width' => 1200,
        'height' => 630,
    ],

    // The cache location to use.
    'storage' => [
        'disk' => 'public',
        'path' => 'social/open-graph',
    ],

    // Whether to use the browse URL instead of the HTML input.
    // This is slower, but makes fonts available.
    // Alternative: http
    'method' => 'html',

    'metatags' => [
        'og:title' => 'title',
        'og:description' => 'description',
        'og:type' => 'type',
        'og:url' => 'url',
    ],
];
```

## Usage

Just add this blade component into the head of your page.

```html
<x-open-graph-image::metatags title="Vormkracht10" subtitle="Slimme websites" />
```

If you don't want to use the blade component you can also use the facade or helper method to generate the url to the image.

```php
// Facade
use Vormkracht10\LaravelOpenGraphImage\Facades\OpenGraphImage;

OpenGraphImage::url(['title' => 'Vormkracht10', 'subtitle' => 'Slimme websites']);

// Helper
og(['title' => 'Vormkracht10', 'subtitle' => 'Slimme websites']);
```

When you share the page on any platform, the image will automatically be generated, cached and then shown in your post. The image from the default template will look like this:

![Default template](docs/open-graph-image-template.jpeg)

This component uses the 'template' blade view by default. You can change this template to your needs. It is even possible to pass more attributes than the default ones. You can find the default template in the resources folder.

### Passing extra attributes

Want to add more custom attributes to modify the button text for example? Simply pass them down to the blade component, facade or helper method:

```html
<x-open-graph-image::metatags
    title="Vormkracht10"
    subtitle="Slimme websites"
    button="Lees meer"
/>
```

```php
// Facade
use Vormkracht10\LaravelOpenGraphImage\Facades\OpenGraphImage;

OpenGraphImage::url(['title' => 'Vormkracht10', 'subtitle' => 'Slimme websites', 'button' => 'Lees meer']);

// Helper
og(['title' => 'Vormkracht10', 'subtitle' => 'Slimme websites', 'button' => 'Lees meer']);
```

You can now access the variable in the `template.blade.php` by using the `{{ $button }}` variable.

### Clearing cached images

All generated open graph images are cached by default. If you want to remove the cache, you can use the following command:

```bash
php artisan open-graph-image:clear-cache
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/vormkracht10/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Bas van Dinther](https://github.com/baspa)
-   [Mark van Eijk](https://github.com/markvaneijk)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
