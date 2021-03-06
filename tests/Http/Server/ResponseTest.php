<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Http\Server;

use Citrus\Http\Server\Response;
use PHPUnit\Framework\TestCase;

/**
 * レスポンスクラスのテスト
 */
class ResponseTest extends TestCase
{
    /**
     * @test
     */
    public function constructor_想定通り()
    {
        $items = [
            'hoge',
            'fuga',
        ];
        $response = new Response($items);
        $this->assertSame($items, $response->items);
        $this->assertTrue($response->result);
    }



    /**
     * @test
     */
    public function success_想定通り()
    {
        $response = Response::success();
        $this->assertSame([], $response->items);
        $this->assertTrue($response->result);
    }



    /**
     * @test
     */
    public function failure_想定通り()
    {
        $response = Response::failure();
        $this->assertSame([], $response->items);
        $this->assertFalse($response->result);
    }



    /**
     * @test
     */
    public function toJson_想定通り()
    {
        $items = [
            'hoge',
            'fuga',
        ];
        $response = new Response($items);
        $this->assertSame(json_encode(['result' => true, 'items' => $items, 'messages' => []]), $response->toJson());
    }
}
