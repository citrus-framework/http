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
}
