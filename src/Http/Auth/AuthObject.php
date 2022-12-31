<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2022, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Http\Auth;

/**
 * 認証クラスの共通箇所の抽象
 */
interface AuthObject
{
    /**
     * 認証タイプを取得する
     *
     * @return AuthType 認証タイプ
     */
    public function authType(): AuthType;
}
