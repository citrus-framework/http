<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Http;

/**
 * リクエスト処理
 */
class Request
{
    use Get;
    use Post;
    use Json;

    /** @var string メソッド */
    private $method;

    /** @var array $_FILES */
    private $files = [];

    /** @var int request time unit timestamp */
    private $request_time;

    /** @var string request path http://example.com/hoge/fuga => "/hoge/fuga" */
    private $request_path;



    /**
     * オブジェクトの生成
     *
     * @throws HttpException
     */
    public static function generate()
    {
        $self = new self();
        // メソッドの判定
        $self->method = Method::judgement();

        // リクエスト情報
        $self->setupGet();
        $self->setupPost();
        $self->setupJson();
        $self->files = $_FILES;

        // リクエスト時間
        $self->request_time = $_SERVER['REQUEST_TIME'];
        $parsed_uri = parse_url($_SERVER['REQUEST_URI']);
        // リクエストパス
        $self->request_path = ($parsed_uri['path'] ?? '');

        return $self;
    }



    /**
     * リクエスト時間の取得
     *
     * @return int
     */
    public function requestTime(): int
    {
        return $this->request_time;
    }



    /**
     * リクエストパスの取得
     *
     * @return string
     */
    public function requestPath(): string
    {
        return $this->request_path;
    }
}
