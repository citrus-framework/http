<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusCollection. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Http;

use Citrus\Http\HttpException;
use Citrus\Http\Request;
use PHPUnit\Framework\TestCase;

/**
 * リクエストクラスのテスト
 */
class RequestTest extends TestCase
{
    /**
     * @test
     * @throws HttpException
     */
    public function generate_データが初期化されている()
    {
        $_GET['hoge1'] = 'fuga1';
        $_POST['hoge2'] = 'fuga2';
        $_SERVER['REQUEST_URI'] = 'http://example.com/';
        
        $request = Request::generate();

        $this->assertSame('fuga1', $request->get('hoge1'));
        $this->assertSame('fuga2', $request->post('hoge2'));
        $this->assertTrue($request->isGet());
        $this->assertTrue($request->isPost());
    }
}
