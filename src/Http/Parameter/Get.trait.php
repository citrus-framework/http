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
 * GET処理
 */
trait Get
{
    /** @var array $_GET */
    private $get = [];



    /**
     * GETデータの取得
     *
     * @param string $path パス
     * @return mixed
     */
    public function get(string $path)
    {
        return Arrays::path($this->get, $path);
    }



    /**
     * GETデータの取得(全て)
     *
     * @return array
     */
    public function gets(): array
    {
        return $this->get;
    }



    /**
     * GETデータがあるかどうか
     *
     * @return bool true:GETデータがある
     */
    public function isGet(): bool
    {
        return (0 < count($this->get));
    }



    /**
     * GETデータの設定
     */
    private function setupGet(): void
    {
        $this->get = $_GET;
    }
}
