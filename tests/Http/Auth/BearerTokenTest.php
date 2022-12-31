<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2022, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Http\Auth;

use Citrus\Http\Auth\AuthType;
use Citrus\Http\Auth\BearerToken;
use PHPUnit\Framework\TestCase;

/**
 * Bearer Tokenのテスト
 */
class BearerTokenTest extends TestCase
{
    /**
     * @test
     */
    public function authType_想定通り()
    {
        $bearerToken = new BearerToken('TESTTEST');
        // 検算
        $this->assertSame(AuthType::BEARER_TOKEN, $bearerToken->authType());
    }

    /**
     * @test
     */
    public function authorizationToken_想定通り()
    {
        $bearerToken = new BearerToken('TESTTEST');
        // 検算
        $this->assertSame('Bearer TESTTEST', $bearerToken->authorizationToken());
    }
}
