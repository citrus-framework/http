<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Http\Server\Method;

use Citrus\Variable\Arrays;

/**
 * POST処理
 */
trait Post
{
    /** @var array $_POST */
    private $post = [];



    /**
     * POSTデータの取得
     *
     * @param string $path パス
     * @return mixed
     */
    public function post(string $path)
    {
        return Arrays::path($this->post, $path);
    }



    /**
     * POSTデータの取得(全て)
     *
     * @return array
     */
    public function posts(): array
    {
        return $this->post;
    }



    /**
     * POSTデータがあるかどうか
     *
     * @return bool true:POSTデータがある
     */
    public function isPost(): bool
    {
        return (0 < count($this->post));
    }



    /**
     * POSTデータの設定
     */
    private function setupPost(): void
    {
        $this->post = $_POST;
    }
}
