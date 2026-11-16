<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Http\Client;

use Citrus\Http\Client;
use Citrus\Http\Client\BodyType;
use Citrus\Http\Client\Request;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * リクエストクラスのテスト
 */
class RequestTest extends TestCase
{
    #[Test]
    public function 既定値_本文の形はFORM_タイムアウトはnull()
    {
        $request = new Request('http://example.com/', []);
        $this->assertSame(BodyType::FORM, $request->bodyType);
        $this->assertNull($request->timeout);
    }

    #[Test]
    public function setBodyType_想定通り()
    {
        $request = (new Request('http://example.com/', []))->setBodyType(BodyType::JSON);
        $this->assertSame(BodyType::JSON, $request->bodyType);
    }

    #[Test]
    public function setTimeout_想定通り()
    {
        $request = new Request('http://example.com/', []);
        $this->assertSame(5, $request->setTimeout(5)->timeout);
        $this->assertNull($request->setTimeout(null)->timeout);
    }

    #[Test]
    public function get_想定通り()
    {
        $response = Client::get('http://example.com/');
        $this->assertSame(200, $response->status);
        $this->assertGreaterThanOrEqual(0, count($response->headers));
        $this->assertGreaterThanOrEqual(0, strlen($response->body));
    }
}
