<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2022, CitrusHttp. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Citrus\Http\Auth;

/**
 * 認証クラスの種別
 */
enum AuthType: string
{
    /** Bearer Token */
    case BEARER_TOKEN = 'BearerToken';
}
