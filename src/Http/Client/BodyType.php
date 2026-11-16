<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Http\Client;

/**
 * リクエストの本文の形
 */
enum BodyType: string
{
    /** フォーム(application/x-www-form-urlencoded) */
    case FORM = 'form';

    /** JSON(application/json) */
    case JSON = 'json';
}
