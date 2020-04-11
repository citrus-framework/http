<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Http;

use Citrus\Variable\Arrays;

/**
 * JSON処理
 */
trait Json
{
    /** @var array $_JSON */
    private $json = [];



    /**
     * JSONデータの取得
     *
     * @param string $path パス
     * @return mixed
     */
    public function json(string $path)
    {
        return Arrays::path($this->json, $path);
    }



    /**
     * JSONデータの取得(全て)
     *
     * @return array
     */
    public function jsons(): array
    {
        return $this->json;
    }



    /**
     * JSONデータがあるかどうか
     *
     * @return bool true:JSONデータがある
     */
    public function isJson(): bool
    {
        return (0 < count($this->json));
    }
}
