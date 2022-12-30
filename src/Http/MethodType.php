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
enum MethodType: string
{
    /** GET */
    case GET = 'get';

    /** POST */
    case POST = 'post';

    /** PUT  */
    case PUT = 'put';

    /** DELETE  */
    case DELETE = 'delete';

    /** HEAD  */
    case HEAD = 'head';

    /** OPTIONS  */
    case OPTIONS = 'options';

    /** TRACE  */
    case TRACE = 'trace';

    /** CONNECT  */
    case CONNECT = 'connect';



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

        /** @var string[] $methods */
        $methods = array_map(fn (MethodType $method) => $method->value, self::cases());

        // 未定義のメソッドはありえない、とする
        HttpException::exceptionElse(
            in_array($request_method, $methods, true),
            sprintf('未定義のリクエストメソッド「%s」', $request_method)
        );

        return $request_method;
    }
}
