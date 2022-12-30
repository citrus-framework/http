<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Http\Client;

use Citrus\Http\Auth\BearerToken;
use Citrus\Http\Client\Header;
use PHPUnit\Framework\TestCase;

/**
 * ヘッダクラスのテスト
 */
class HeaderTest extends TestCase
{
    /**
     * @test
     */
    public function authorizationBearer_想定通り()
    {
        $header = Header::getInstance()->authorizationBearer('TESTTEST');
        // 検算
        $this->assertSame(['Authorization: Bearer TESTTEST'], $header->toArray());
    }

    /**
     * @test
     */
    public function authorization_想定通り()
    {
        $bearerToken = new BearerToken('TESTTEST');

        $header = Header::getInstance()->authorization($bearerToken);
        // 検算
        $this->assertSame(['Authorization: Bearer TESTTEST'], $header->toArray());
    }
}
