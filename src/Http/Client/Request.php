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

    /** @var Header ヘッダ情報 */
    public $header;



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
     * @return $this
     */
    public function setMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }



    /**
     * ヘッダ指定
     *
     * @param Header $header
     * @return $this
     */
    public function setHeader(Header $header): self
    {
        $this->header = $header;
        return $this;
    }



    /**
     * パラメータ設定
     *
     * @param array $parameters パラメータ
     * @return $this
     */
    public function setParameters(array $parameters): self
    {
        $this->parameters = $parameters;
        return $this;
    }



    /**
     * クエリ文字列を生成して返却
     *
     * @return string
     */
    public function makeQueryParameters(): string
    {
        if (0 < count($this->parameters))
        {
            return http_build_query($this->parameters);
        }
        return '';
    }



    /**
     * クエリURL
     *
     * @param string|null $query_parameter クエリパラメーター
     * @return string
     */
    public function makeURL(string $query_parameter = null): string
    {
        $query_parameter = $query_parameter ?? $this->makeQueryParameters();
        return sprintf('%s?%s', $this->url, $query_parameter);
    }
}
