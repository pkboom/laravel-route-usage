# Route usage counter for Laravel apps

[![Latest Stable Version](https://poser.pugx.org/pkboom/laravel-route-usage/v/stable)](https://packagist.org/packages/pkboom/laravel-route-usage)
[![Total Downloads](https://poser.pugx.org/pkboom/laravel-route-usage/downloads)](https://packagist.org/packages/pkboom/laravel-route-usage)
[![Build Status](https://travis-ci.com/pkboom/laravel-route-usage.svg?branch=master)](https://travis-ci.com/pkboom/laravel-route-usage)

This Laravel package shows a route usage.

This is a demo result.
<img src="/images/demo.png" width="800"  title="demo">

## Installation

You can install the package via composer:

```bash
composer require pkboom/laravel-route-usage
```

Run the migration:

```bash
php artisan migrate
```

## Usage

You can see a route usage with:

```bash
php artisan route-usage:show
```

You can remove a route usage that are older than 1 month:

```bash
php artisan route-usage:remove
```

You can see referers.

```bash
php artisan route-usage:referers
```

<img src="/images/demo2.png" width="600"  title="demo2">

You can see run time.

```bash
php artisan route-usage:runtime
```

<img src="/images/demo2.png" width="600"  title="demo3">

You can optionally publish the config file with:

```bash
php artisan vendor:publish --provider="Pkboom\RouteUsage\RouteUsageServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
<?php

return [
    /*
     * List of uris to be excluded when route-usage:show runs.
     */
    'exclude' => [
        '_debugbar/*', 'horizon/*', 'telescope/*',
    ],
];
```

### Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [MIT license](http://opensource.org/licenses/MIT) for more information.
