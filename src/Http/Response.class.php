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

    /** @var array result object */
    public $items = [];



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



    /**
     * JSON文字列を返却
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this);
    }
}
