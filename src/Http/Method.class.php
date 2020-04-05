<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Http;

/**
 * メソッド
 */
class Method
{
    /** @var string GET */
    public const GET = 'get';

    /** @var string POST */
    public const POST = 'post';

    /** @var string PUT  */
    public const PUT = 'put';

    /** @var string DELETE  */
    public const DELETE = 'delete';

    /** @var string HEAD  */
    public const HEAD = 'head';

    /** @var string OPTIONS  */
    public const OPTIONS = 'options';

    /** @var string TRACE  */
    public const TRACE = 'trace';

    /** @var string CONNECT  */
    public const CONNECT = 'connect';

    /** @var string[] メソッドリスト */
    public static $LISTS = [
        self::GET,
        self::POST,
        self::PUT,
        self::DELETE,
        self::HEAD,
        self::OPTIONS,
        self::TRACE,
        self::CONNECT,
    ];



    /**
     * メソッドを判別する
     *
     * @return string
     * @throws HttpException
     */
    public static function judgement(): string
    {
        // グローバル変数から取得
        $request_method = strtolower($_SERVER['REQUEST_METHOD'] ?? '');

        // 精査
        if (true === in_array($request_method, self::$LISTS, true))
        {
            // 未定義のメソッドはありえない、とする
            throw new HttpException(sprintf('未定義のリクエストメソッド「%s」', $request_method));
        }
        return $request_method;
    }
}
