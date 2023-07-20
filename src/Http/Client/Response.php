<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Http\Client;

use Citrus\Variable\Strings;

/**
 * レスポンス処理
 * このライブラリが配置される場所から他方へアクセスする場合
 */
class Response
{
    /** @var int ステータスコード */
    public int $status;

    /** @var array ヘッダー配列 */
    public array $headers = [];

    /** @var string レスポンスボディ */
    public string $body = '';



    /**
     * cURLのハンドルから情報を取得して設定
     *
     * @param \CurlHandle $handle cURLハンドル
     * @return $this
     */
    public function bind(\CurlHandle $handle): self
    {
        // 情報取得ように固定設定するオプション
        curl_setopt_array($handle, [
            CURLOPT_HEADER => true, // ヘッダ内容を出力しない
            CURLOPT_RETURNTRANSFER => true, // 結果を文字列で返却
        ]);

        // データ取得
        $result = curl_exec($handle);
        // 情報取得
        $info = curl_getinfo($handle);
        // ステータスコード
        $this->status = $info['http_code'];

        // ヘッダサイズ
        $header_size = $info['header_size'];
        // ヘッダとボディに分割
        $header = substr($result, 0, $header_size);
        $this->body = substr($result, $header_size);

        // ヘッダの改行コードをなめす
        $header = str_replace(["\r\n", "\r", "\n"], PHP_EOL, $header);
        $headers = explode(PHP_EOL, $header);
        // 配列に設定
        foreach ($headers as $row)
        {
            // 空文字 or 区切り文字がない場合はスキップ
            if (true === Strings::isEmpty($row) or false === strpos($row, ':'))
            {
                continue;
            }

            [$ky, $vl] = explode(':', $row);
            $this->headers[$ky] = trim($vl);
        }

        return $this;
    }
}
