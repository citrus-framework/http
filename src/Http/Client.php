<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Http;

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
     * @return string
     */
    public static function get(string $url, array $parameters = []): string
    {
        return self::request($url, Method::GET, $parameters);
    }



    /**
     * postリクエスト
     *
     * @param string $url
     * @param mixed  $parameters
     * @return string
     */
    public static function post(string $url, $parameters = []): string
    {
        return self::request($url, Method::POST, $parameters);
    }


    /**
     * リクエストを送る
     *
     * @param string       $url        URL
     * @param string       $method     リクエストメソッド
     * @param string|array $parameters パラメタ
     * @return string
     */
    private static function request(string $url, string $method, $parameters): string
    {
        // 接続オプション配列
        $options = [];
        // クエリパラメータが配列なら文字列化
        $http_query = (true === is_array($parameters) ? http_build_query($parameters) : $parameters);

        // リクエストパラメータ(GET)
        if (Method::GET === $method)
        {
            // GETリクエストの場合にクエリパラメータにくっつける
            $url = sprintf('%s?%s', $url, $http_query);
        }
        // リクエストパラメータ(POST)
        if (Method::POST === $method)
        {
            $options += [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $http_query, // パラメータをPOSTフィールドへ
            ];
        }

        // 固定的に設定しておくオプション
        $options += [
            CURLOPT_URL => $url, // URL
            CURLOPT_HEADER => false, // ヘッダ内容を出力しない
            CURLOPT_RETURNTRANSFER => true, // 結果を文字列で返却
            CURLOPT_FOLLOWLOCATION => true, // Locationヘッダが有る場合に追跡する
        ];

        return self::curlRequest($options);
    }



    /**
     * cURLでアクセスしてレスポンスを得る
     *
     * @param array $options curlのオプション配列
     * @return string
     */
    private static function curlRequest(array $options): string
    {
        // 接続開始
        $handle = curl_init();

        // オプション設定
        curl_setopt_array($handle, $options);

        // 実行
        $result = curl_exec($handle);

        // 接続終了
        curl_close($handle);

        return $result;
    }
}
