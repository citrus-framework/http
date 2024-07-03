<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Http\Server;

/**
 * レスポンス処理
 * このライブラリが配置される場所をサーバーとする場合
 */
class Response extends ResponseTo
{
    /**
     * constructor.
     * @param array|null    $items    返却配列
     * @param array|null    $messages メッセージ配列
     * @param bool|null     $result   結果
     * @param string[]|null $headers  ヘッダー配列
     */
    public function __construct(
        public array|null $items = [],
        public array|null $messages = [],
        public bool|null $result = false,
        protected array|null $headers = [],
    ) {
        $this->result = (0 < count($this->items));
    }

    /**
     * 結果アイテムの追加
     * @param \ArrayAccess $item 結果アイテム
     * @return $this
     */
    public function addItem(\ArrayAccess $item): self
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * 結果メッセージの追加
     * @param string $message 結果メッセージ
     * @return $this
     */
    public function addMessage(string $message): self
    {
        $this->messages[] = $message;
        return $this;
    }

    /**
     * success
     * @return $this
     */
    public static function success(): self
    {
        $self = new self();
        $self->result = true;
        return $self;
    }

    /**
     * failure
     * @return $this
     */
    public static function failure(): self
    {
        $self = new self();
        $self->result = false;
        return $self;
    }

    /**
     * ヘッダーを出力する
     * @return void
     */
    public function outputHeaders(): void
    {
        foreach ($this->headers as $header)
        {
            header($header);
        }
    }
}
