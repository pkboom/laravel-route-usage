<?php

namespace Pkboom\RouteUsage\Sources;

/**
 * @see https://github.com/spatie/laravel-referer/blob/master/src/Sources/UtmSource.php
 */
class UtmSource
{
    public function getReferer($request)
    {
        return $request->get('utm_source') ?? '';
    }
}
