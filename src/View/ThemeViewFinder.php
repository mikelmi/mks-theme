<?php
/**
 * Author: mike
 * Date: 26.09.16
 * Time: 13:40
 */

namespace Mikelmi\MksTheme\View;


use Illuminate\View\FileViewFinder;

class ThemeViewFinder extends FileViewFinder
{
    /**
     * Prepend a location to the finder.
     *
     * @param string $path
     */
    public function prependLocation($path)
    {
        array_unshift($this->paths, $path);
    }
}