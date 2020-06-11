<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Http\Client;

use Citrus\Http\Method;

/**
 * リクエスト処理
 * このライブラリが配置される場所から他方へアクセスする場合
 */
class Request
{
    /** @var string URL */
    public $url;

    /** @var string メソッド */
    public $method = Method::GET;

    /** @var array リクエストパラメータ */
    public $parameters = [];



    /**
     * constructor.
     *
     * @param string $url URL
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }



    /**
     * メソッド指定
     *
     * @param string $method
     * @return self
     */
    public function setMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }



    /**
     * パラメータ設定
     *
     * @param array $parameters パラメータ
     * @return self
     */
    public function setParameters(array $parameters): self
    {
        $this->parameters = $parameters;
        return $this;
    }
}
