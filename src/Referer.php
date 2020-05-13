<?php

namespace Pkboom\RouteUsage;

use Pkboom\RouteUsage\Sources\UtmSource;
use Pkboom\RouteUsage\Sources\RequestHeader;

/**
 * @see https://github.com/spatie/laravel-referer/blob/master/src/Referer.php
 */
class Referer
{
    protected $sources = [
        UtmSource::class,
        RequestHeader::class,
    ];

    public function get($request)
    {
        foreach ($this->sources as $source) {
            if ($referer = (new $source())->getReferer($request)) {
                return $referer;
            }
        }

        return '';
    }
}
