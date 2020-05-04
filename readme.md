# Route usage counter for Laravel apps

[![Latest Stable Version](https://poser.pugx.org/pkboom/laravel-route-usage/v/stable)](https://packagist.org/packages/pkboom/laravel-route-usage)
[![Build Status](https://travis-ci.com/pkboom/laravel-route-usage.svg?branch=master)](https://travis-ci.com/pkboom/laravel-route-usage)

This Laravel package shows a route usage.

This is a demo result.
<img src="/images/result.png" width="800"  title="result">

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

```php
php artisan route-usage:show
```

You can remove a route usage that are older than 6 months:

```php
php artisan route-usage:remove
```

### Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [MIT license](http://opensource.org/licenses/MIT) for more information.
