<?php

namespace App\Traits;

trait UseToken
{
    public static function comparison()
    {
        return request('token') === config('app.api-key') ? true : false;
    }
}
