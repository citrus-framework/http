<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test\Http;

use Citrus\Http\Client;
use Citrus\Http\Client\BodyType;
use Citrus\Http\Client\Header;
use Citrus\Http\Client\Request;
use Citrus\Http\HttpException;
use Citrus\Http\MethodType;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * Httpクライアントのテスト(組み込みサーバーに実際に送る)
 */
class ClientTest extends TestCase
{
    /** @var resource|null 組み込みサーバーのプロセス */
    private static $process = null;

    /** @var string 組み込みサーバーのURL */
    private static string $base = '';

    public static function setUpBeforeClass(): void
    {
        // 空いているポートを探す
        $socket = stream_socket_server('tcp://127.0.0.1:0');
        $name = stream_socket_get_name($socket, false);
        fclose($socket);
        $port = (int)substr($name, strrpos($name, ':') + 1);

        self::$base = sprintf('http://127.0.0.1:%d', $port);
        $command = [PHP_BINARY, '-S', sprintf('127.0.0.1:%d', $port), __DIR__ . '/../Fixture/server.php'];
        $descriptors = [0 => ['pipe', 'r'], 1 => ['file', '/dev/null', 'w'], 2 => ['file', '/dev/null', 'w']];
        self::$process = proc_open($command, $descriptors, $pipes);

        // 起動待ち
        for ($i = 0; $i < 50; $i++)
        {
            $connection = @fsockopen('127.0.0.1', $port);
            if ($connection !== false)
            {
                fclose($connection);
                return;
            }
            usleep(100000);
        }
        self::fail('組み込みサーバーが起動しませんでした。');
    }

    public static function tearDownAfterClass(): void
    {
        if (is_resource(self::$process) === true)
        {
            proc_terminate(self::$process);
            proc_close(self::$process);
        }
    }

    #[Test]
    public function request_JSONの本文とContentTypeが送られる()
    {
        $request = new Request(self::$base . '/echo', ['text' => 'こんにちは/', 'n' => 1], MethodType::POST, null, BodyType::JSON);
        $response = Client::request($request);
        $result = json_decode($response->body, true);
        $this->assertSame('{"text":"こんにちは/","n":1}', $result['body']);
        $this->assertSame('application/json', $result['content_type']);
    }

    #[Test]
    public function request_FORMは今のまま()
    {
        $response = Client::post(self::$base . '/echo', ['a' => 'b']);
        $result = json_decode($response->body, true);
        $this->assertSame('a=b', $result['body']);
        $this->assertSame('application/x-www-form-urlencoded', $result['content_type']);
    }

    #[Test]
    public function request_呼んだ側のContentTypeが優先され_Headerは書き換わらない()
    {
        $header = Header::getInstance()->addHeader('content-type', 'application/json; charset=utf-8');
        $request = new Request(self::$base . '/echo', ['a' => 'b'], MethodType::POST, $header, BodyType::JSON);
        $response = Client::request($request);
        $result = json_decode($response->body, true);
        $this->assertSame('{"a":"b"}', $result['body']);
        $this->assertSame('application/json; charset=utf-8', $result['content_type']);
        $this->assertSame(['content-type' => 'application/json; charset=utf-8'], $header->stacks);
    }

    #[Test]
    public function request_ContentTypeが無いとき呼んだ側のHeaderは書き換わらない()
    {
        $header = Header::getInstance()->addHeader('X-Test', '1');
        $request = new Request(self::$base . '/echo', ['a' => 'b'], MethodType::POST, $header, BodyType::JSON);
        $response = Client::request($request);
        $result = json_decode($response->body, true);
        $this->assertSame('application/json', $result['content_type']);
        $this->assertSame(['X-Test' => '1'], $header->stacks);
    }

    #[Test]
    public function request_タイムアウトを超えるとHttpException()
    {
        $request = new Request(self::$base . '/sleep?seconds=3', [], MethodType::GET, null, BodyType::FORM, 1);
        $this->expectException(HttpException::class);
        Client::request($request);
    }

    #[Test]
    public function request_タイムアウト内なら返る()
    {
        $request = (new Request(self::$base . '/sleep?seconds=1', []))->setTimeout(5);
        $this->assertSame('done', Client::request($request)->body);
    }

    #[Test]
    public function request_つながらないとHttpException()
    {
        $this->expectException(HttpException::class);
        $this->expectExceptionCode(CURLE_COULDNT_CONNECT);
        Client::request(new Request('http://127.0.0.1:1/', [], MethodType::GET, null, BodyType::FORM, 2));
    }
}
