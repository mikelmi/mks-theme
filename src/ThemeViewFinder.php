<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 26.09.16
 * Time: 13:40
 */

namespace Mikelmi\MksTheme;


use Illuminate\View\FileViewFinder;

class ThemeViewFinder extends FileViewFinder
{
    public function prependLocation($path)
    {
        array_unshift($this->paths, $path);
    }
}