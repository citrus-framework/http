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
class BearerToken implements AuthObject, HeaderAuthorizationToken
{
    /**
     * constructor.
     *
     * @param string $bearer_token Bearer Token
     */
    public function __construct(
        public string $bearer_token
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function authType(): AuthType
    {
        return AuthType::BEARER_TOKEN;
    }

    /**
     * {@inheritDoc}
     */
    public function authorizationToken(): string
    {
        return sprintf('Bearer %s', $this->bearer_token);
    }
}
