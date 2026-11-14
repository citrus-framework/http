<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Http;

use Citrus\Http\Client\Request;
use Citrus\Http\Client\Response;

/**
 * Httpクライアント
 */
class Client
{
    /**
     * getリクエスト
     * @param string   $url
     * @param string[] $parameters
     * @return Response
     */
    public static function get(string $url, array $parameters = []): Response
    {
        return self::request(new Request($url, $parameters));
    }

    /**
     * postリクエスト
     * @param string   $url
     * @param string[] $parameters
     * @return Response
     */
    public static function post(string $url, array $parameters = []): Response
    {
        return self::request(new Request($url, $parameters, MethodType::POST));
    }

    /**
     * リクエストを送る
     * @param Request $request リクエスト情報
     * @return Response
     */
    public static function request(Request $request): Response
    {
        $url = $request->url;
        // 接続オプション配列
        $options = [];
        // クエリパラメータが配列なら文字列化
        $http_query = $request->makeQueryParameters();

        // リクエストパラメータ(GET)
        if ($request->method === MethodType::GET)
        {
            // GETリクエストの場合にクエリパラメータにくっつける
            $url = $request->makeURL($http_query);
        }
        // リクエストパラメータ(POST)
        if ($request->method === MethodType::POST)
        {
            $options += [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $http_query, // パラメータをPOSTフィールドへ
            ];
        }

        // 固定的に設定しておくオプション
        $options += [
            CURLOPT_URL => $url, // URL
            CURLOPT_FOLLOWLOCATION => true, // Locationヘッダが有る場合に追跡する
        ];

        // ヘッダ情報がある場合
        if (is_null($request->header) === false)
        {
            $options += [
                CURLOPT_HTTPHEADER => $request->header->toArray(),
            ];
        }

        // 接続開始
        $handle = curl_init();
        // オプション設定
        curl_setopt_array($handle, $options);
        // 実行して情報を取得(接続は、ハンドルが使われなくなったときに閉じる)
        return (new Response())->bind($handle);
    }
}
