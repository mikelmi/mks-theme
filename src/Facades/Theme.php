<?php

namespace Mikelmi\MksTheme\Facades;


use Illuminate\Support\Facades\Facade;

class Theme extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Mikelmi\MksTheme\Services\Theme::class;
    }
}