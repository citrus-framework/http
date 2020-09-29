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
     *
     * @param string $url
     * @param array  $parameters
     * @return Response
     */
    public static function get(string $url, array $parameters = []): Response
    {
        return self::request(
            (new Request($url))->setMethod(Method::GET)->setParameters($parameters)
        );
    }



    /**
     * postリクエスト
     *
     * @param string $url
     * @param mixed  $parameters
     * @return Response
     */
    public static function post(string $url, $parameters = []): Response
    {
        return self::request(
            (new Request($url))->setMethod(Method::POST)->setParameters($parameters)
        );
    }



    /**
     * リクエストを送る
     *
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
        if (Method::GET === $request->method)
        {
            // GETリクエストの場合にクエリパラメータにくっつける
            $url = $request->makeURL($http_query);
        }
        // リクエストパラメータ(POST)
        if (Method::POST === $request->method)
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
        if (false === is_null($request->header))
        {
            $options += [
                CURLOPT_HTTPHEADER => $request->header->toArray(),
            ];
        }

        // 接続開始
        $handle = curl_init();
        // オプション設定
        curl_setopt_array($handle, $options);
        // 実行して情報を取得
        $response = (new Response())->bind($handle);
        // 接続終了
        curl_close($handle);
        return $response;
    }
}
