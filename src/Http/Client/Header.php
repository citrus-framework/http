<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Http\Client;

use Citrus\Http\Auth\AuthPattern;
use Citrus\Http\Auth\HeaderAuthorizationToken;
use Citrus\Variable\Instance;

/**
 * リクエスト処理時のヘッダ情報
 */
class Header
{
    use Instance;

    /** @var string ContentType */
    public const CONTENT_TYPE = 'Content-Type';

    /** @var string Authorization */
    public const AUTHORIZATION = 'Authorization';

    /** @var array [string => string...] ヘッダー情報をスタックする */
    public $stacks = [];



    /**
     * ヘッダ情報の設定
     *
     * @param string $key   ヘッダキー
     * @param string $value ヘッダ値
     * @return $this
     */
    public function addHeader(string $key, string $value): self
    {
        $this->stacks[$key] = $value;
        return $this;
    }



    /**
     * Bearer認証用トークン設定
     *
     * @param string $token トークン文字列
     * @return $this
     */
    public function authorizationBearer(string $token): self
    {
        return $this->addHeader(self::AUTHORIZATION, sprintf('Bearer %s', $token));
    }

    /**
     * 認証用トークン設定
     *
     * @param AuthPattern|HeaderAuthorizationToken $authPattern 認証
     * @return $this
     */
    public function authorization(AuthPattern|HeaderAuthorizationToken $authPattern): self
    {
        if ($authPattern instanceof HeaderAuthorizationToken)
        {
            return $this->addHeader(self::AUTHORIZATION, $authPattern->authorizationToken());
        }
        return $this;
    }

    /**
     * curl_setopt の CURLOPT_HTTPHEADER に設定できるように文字列配列で返却する
     *
     * @return string[]
     */
    public function toArray()
    {
        $result = [];
        foreach ($this->stacks as $ky => $vl)
        {
            $result[] = sprintf('%s: %s', $ky, $vl);
        }
        return $result;
    }
}
