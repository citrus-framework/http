<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Http;

/**
 * リダイレクト処理
 */
class Redirect
{
    /**
     * リダイレクト
     *
     * @param string $location リダイレクト先
     */
    public static function to(string $location): void
    {
        header(sprintf('Location: %s', $location));
        exit;
    }



    /**
     * status 401
     */
    public static function status401(): void
    {
        header('HTTP/1.0 401 Unauthorized');
    }



    /**
     * status 403
     */
    public static function status403(): void
    {
        header('HTTP/1.0 403 Forbidden');
    }



    /**
     * status 404
     */
    public static function status404(): void
    {
        header('HTTP/1.0 404 Not Found');
    }



    /**
     * status 503
     */
    public static function status503(): void
    {
        header('HTTP/1.0 503 Service Unavailable');
    }
}
