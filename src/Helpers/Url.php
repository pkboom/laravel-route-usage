<?php

namespace Pkboom\RouteUsage\Helpers;

/**
 * @see https://github.com/spatie/laravel-referer/blob/master/src/Helpers/Url.php
 */
class Url
{
    public static function host(string $url): string
    {
        $parts = parse_url($url);

        if ($parts === false || !isset($parts['host'])) {
            return '';
        }

        return $parts['host'];
    }
}
