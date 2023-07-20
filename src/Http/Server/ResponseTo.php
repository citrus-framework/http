<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Http\Server;

/**
 * レスポンス処理
 * このライブラリが配置される場所をサーバーとする場合
 */
abstract class ResponseTo
{
    /**
     * 文字列を返却
     *
     * @return string
     */
    public function toString(): string
    {
        return serialize($this);
    }

    /**
     * JSON文字列を返却
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this);
    }
}
