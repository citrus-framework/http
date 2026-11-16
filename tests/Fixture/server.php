<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

/**
 * テスト用の組み込みサーバーの入口
 * /echo  受け取った本文と Content-Type を JSON で返す
 * /sleep ?seconds=N の秒数だけ眠ってから返す
 */
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path === '/echo')
{
    header('Content-Type: application/json');
    echo json_encode([
        'body' => file_get_contents('php://input'),
        'content_type' => $_SERVER['CONTENT_TYPE'] ?? '',
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    return;
}

if ($path === '/sleep')
{
    sleep((int)($_GET['seconds'] ?? 0));
    echo 'done';
    return;
}

http_response_code(404);
