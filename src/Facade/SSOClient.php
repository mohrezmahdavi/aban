<?php

namespace Raahin\Aban\Facade;

use Illuminate\Support\Facades\Facade;

class SSOClient extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ssoclient';
    }
}