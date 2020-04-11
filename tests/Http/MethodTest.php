<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusCollection. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Http;

use Citrus\Http\HttpException;
use Citrus\Http\Method;
use Citrus\Http\Request;
use PHPUnit\Framework\TestCase;

/**
 * メソッドクラスのテスト
 */
class  MethodTest extends TestCase
{
    /**
     * @test
     * @throws HttpException
     */
    public function judgement_想定通り()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        // 検証
        $this->assertSame(Method::POST, Method::judgement());
    }
}
