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
 * リクエスト処理
 */
class Request
{
    /** @var string メソッド */
    private $method;

    /** @var array $_GET */
    private $get = [];

    /** @var array $_POST */
    private $post = [];

    /** @var array $_FILES */
    private $files = [];

    /** @var array php://input */
    private $json = [];

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
        $self->get = $_GET;
        $self->post = $_POST;
        $self->files = $_FILES;
        $self->json = file_get_contents('php://input');

        // リクエスト時間
        $self->request_time = $_SERVER['REQUEST_TIME'];
        $parsed_uri = parse_url($_SERVER['REQUEST_URI']);
        // リクエストパス
        $self->request_path = ($parsed_uri['path'] ?? '');

        return $self;
    }



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
