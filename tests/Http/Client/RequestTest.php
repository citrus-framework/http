<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Http\Client;

use Citrus\Http\Client;
use PHPUnit\Framework\TestCase;

/**
 * リクエストクラスのテスト
 */
class RequestTest extends TestCase
{
    /**
     * @test
     */
    public function get_想定通り()
    {
        $response = Client::get('http://example.com/');
        $this->assertSame(200, $response->status);
        $this->assertGreaterThanOrEqual(0, count($response->headers));
        $this->assertGreaterThanOrEqual(0, strlen($response->body));
    }
}
