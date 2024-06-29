<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Http;

use Citrus\Collection;

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
     * @return MethodType
     * @throws HttpException
     */
    public static function judgement(): MethodType
    {
        // グローバル変数から取得
        $request_method = strtolower($_SERVER['REQUEST_METHOD'] ?? '');

        // 一致するメソッドがあるか？
        $method = Collection::stream(self::cases())->first(function (MethodType $value, $key) use ($request_method) {
            return $value->value === strtolower($request_method);
        });

        // 未定義のメソッドはありえない、とする
        HttpException::exceptionIf(
            is_null($method),
            sprintf('未定義のリクエストメソッド「%s」', $request_method)
        );

        return $method;
    }
}
