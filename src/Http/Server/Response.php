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
class Response implements ResponseTo
{
    /** @var bool result */
    public bool $result = false;

    /** @var array|null result objects */
    public array|null $items = [];

    /** @var array|null message objects */
    public array|null $messages = [];



    /**
     * constructor.
     *
     * @param array|null $items
     */
    public function __construct(array|null $items = [])
    {
        if (0 < count($items))
        {
            $this->result = true;
        }
        $this->items = $items;
    }

    /**
     * 文字列を返却
     *
     * @return string
     */
    public function toString(): string
    {
        return serialize($this);
    }

    /**
     * JSON文字列を返却
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this);
    }

    /**
     * 結果アイテムの追加
     *
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
     *
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
     *
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
     *
     * @return $this
     */
    public static function failure(): self
    {
        $self = new self();
        $self->result = false;
        return $self;
    }
}
