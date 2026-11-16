<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Http;

use Citrus\Http\Client\BodyType;
use Citrus\Http\Client\Header;
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
        // 送るヘッダ(呼んだ側のオブジェクトは書き換えず、配列で組み立てる)
        $headers = is_null($request->header) === false ? $request->header->toArray() : [];
        // リクエストパラメータ(POST)
        if ($request->method === MethodType::POST)
        {
            $post_fields = $http_query;
            // JSONの場合は本文をJSON文字列にする
            if ($request->bodyType === BodyType::JSON)
            {
                $post_fields = json_encode(
                    $request->parameters,
                    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR
                );
                // 呼んだ側がContent-Typeを決めていなければ付ける
                $has_content_type = false;
                foreach (array_keys($request->header->stacks ?? []) as $ky)
                {
                    if (strcasecmp((string)$ky, Header::CONTENT_TYPE) === 0)
                    {
                        $has_content_type = true;
                    }
                }
                if ($has_content_type === false)
                {
                    $headers[] = sprintf('%s: application/json', Header::CONTENT_TYPE);
                }
            }
            $options += [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $post_fields, // パラメータをPOSTフィールドへ
            ];
        }

        // 固定的に設定しておくオプション
        $options += [
            CURLOPT_URL => $url, // URL
            CURLOPT_FOLLOWLOCATION => true, // Locationヘッダが有る場合に追跡する
        ];

        // ヘッダ情報がある場合
        if (count($headers) > 0)
        {
            $options += [
                CURLOPT_HTTPHEADER => $headers,
            ];
        }

        // タイムアウトが指定されている場合
        if (is_null($request->timeout) === false)
        {
            $options += [
                CURLOPT_TIMEOUT => $request->timeout, // 全体の上限秒数
                CURLOPT_CONNECTTIMEOUT => $request->timeout, // 接続の上限秒数
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
