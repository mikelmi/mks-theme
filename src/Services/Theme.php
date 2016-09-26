<?php


namespace Mikelmi\MksTheme\Services;


use Illuminate\Support\Collection;
use Mikelmi\MksTheme\ThemeViewFinder;

class Theme
{
    /**
     * @var ThemeViewFinder
     */
    private $finder;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $pathName;

    /**
     * @var string
     */
    private $theme;

    /**
     * Theme constructor.
     * @param ThemeViewFinder $finder
     * @param null|string $path
     */
    public function __construct(ThemeViewFinder $finder, $path = null)
    {
        $this->finder = $finder;
        $this->path = $path ?: public_path('themes');
        $this->pathName = basename($this->path);
    }

    /**
     * Set current theme
     * @param $name
     */
    public function set($name)
    {
        if ($this->theme != $name) {
            $this->theme = $name;
            $this->updateFinder();
        }
    }

    /**
     * Get current theme
     * @return mixed
     */
    public function get()
    {
        return $this->theme;
    }

    /**
     * @return ThemeViewFinder
     */
    public function getFinder()
    {
        return $this->finder;
    }

    /**
     * Update ViewFinder paths
     */
    protected function updateFinder()
    {
        $path = $this->viewPath();

        if ($path) {
            foreach ($this->finder->getHints() as $namespace => $hints) {
                $p = $path . DIRECTORY_SEPARATOR . $namespace;
                if (is_dir($p))
                    $this->finder->prependNamespace($namespace, $p);
            }

            $this->finder->prependLocation($path);
        }
    }

    /**
     * @param null|string $path
     * @return null|string
     */
    protected function viewPath($path = null)
    {
        if (!$this->theme) {
            return $path;
        }

        return rtrim($this->path, "\\/")
            . DIRECTORY_SEPARATOR
            . $this->theme
            . DIRECTORY_SEPARATOR . 'views'
            . ($path ? DIRECTORY_SEPARATOR . $path : '');
    }

    /**
     * @return Collection;
     */
    public function all()
    {
        return collect($this->finder->getFilesystem()->directories($this->path))
                ->mapWithKeys(function($item) {
                    $name = basename($item);
                    return [$name => ucfirst($item)];
                });
    }

    /**
     * @param string $path
     * @param null $secure
     * @return string
     */
    public function asset($path = '', $secure=null)
    {
        return asset($this->asset_path($path), $secure);
    }

    /**
     * @param $path
     * @return string
     */
    public function asset_path($path)
    {
        return $this->pathName . '/' . $this->theme . '/' . trim($path, '/');
    }

    /**
     * @param null $theme
     * @param null $key
     * @param null $default
     * @return mixed|null
     */
    public function info($theme = null, $key = null, $default = null)
    {
        $name = $theme ?: $this->theme;

        if ($name) {
            $file = $this->pathName . '/' . $name . '/theme.php';

            if (is_file($file)) {
                $config = require($file);

                return array_get($config, $key, $default);
            }
        }

        return $default;
    }
}