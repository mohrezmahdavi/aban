<?php

namespace Raahin\Aban\Facade;

use Illuminate\Support\Facades\Facade;

class SMSClient extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'smsclient';
    }
}