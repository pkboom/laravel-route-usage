<?php

namespace Pkboom\RouteUsage\Sources;

use Pkboom\RouteUsage\Helpers\Url;

/**
 * @see https://github.com/spatie/laravel-referer/blob/master/src/Sources/RequestHeader.php.
 */
class RequestHeader
{
    public function getReferer($request)
    {
        $referer = $request->header('referer', '');

        if (empty($referer)) {
            return '';
        }

        $refererHost = Url::host($referer);

        if (empty($refererHost)) {
            return '';
        }

        if ($refererHost === $request->getHost()) {
            return '';
        }

        return $refererHost;
    }
}
