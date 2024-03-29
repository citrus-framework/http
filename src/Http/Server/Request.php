<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Http\Server;

use Citrus\Http\HttpException;
use Citrus\Http\MethodType;
use Citrus\Http\Server\Method\Get;
use Citrus\Http\Server\Method\Json;
use Citrus\Http\Server\Method\Post;

/**
 * リクエスト処理
 * このライブラリが配置される場所をサーバーとする場合
 */
class Request
{
    use Get;
    use Post;
    use Json;

    /** @var string メソッド */
    private string $method;

    /** @var array $_FILES */
    private array $files = [];

    /** @var int request time unit timestamp */
    private int $request_time;

    /** @var string request path http://example.com/hoge/fuga => "/hoge/fuga" */
    private string $request_path;



    /**
     * オブジェクトの生成
     *
     * @return $this
     * @throws HttpException
     */
    public static function generate(): self
    {
        $self = new self();
        // メソッドの判定
        $self->method = MethodType::judgement();

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
