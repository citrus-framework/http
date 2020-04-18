<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Http;

/**
 * レスポンス処理
 */
class Response
{
    /** @var bool result */
    public $result = false;

    /** @var array result objects */
    public $items = [];

    /** @var array message objects */
    public $messages = [];



    /**
     * constructor.
     *
     * @param array|null $items
     */
    public function __construct(array $items = [])
    {
        if (0 < count($items))
        {
            $this->result = true;
        }
        $this->items = $items;
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
     * @param mixed $item 結果アイテム
     */
    public function addItem($item): void
    {
        $this->items[] = $item;
    }



    /**
     * 結果メッセージの追加
     *
     * @param mixed $message 結果メッセージ
     */
    public function addMessage($message): void
    {
        $this->messages[] = $message;
    }



    /**
     * success
     *
     * @return self
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
     * @return self
     */
    public static function failure(): self
    {
        $self = new self();
        $self->result = false;
        return $self;
    }
}
