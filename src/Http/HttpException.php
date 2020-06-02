<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Http;

use Citrus\CitrusException;

/**
 * リクエスト処理
 */
class HttpException extends CitrusException
{
    /**
     * {@inheritDoc}
     *
     * @throws HttpException
     */
    public static function exceptionIf($expr, string $message): void
    {
        parent::exceptionIf($expr, $message);
    }



    /**
     * {@inheritDoc}
     *
     * @throws HttpException
     */
    public static function exceptionElse($expr, string $message): void
    {
        parent::exceptionElse($expr, $message);
    }
}
