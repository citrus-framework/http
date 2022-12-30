<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2022, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Http\Auth;

/**
 * ヘッダーのAuthorizationトークンで認証するタイプ
 */
interface HeaderAuthorizationToken
{
    /**
     * Authorizationトークン文字列を生成して取得する
     *
     * @return string Authorizationトークン文字列
     */
    public function authorizationToken(): string;
}
