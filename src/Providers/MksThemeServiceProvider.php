<?php

namespace Mikelmi\MksTheme\Providers;


use Illuminate\Support\ServiceProvider;
use Mikelmi\MksTheme\Services\Theme;
use Mikelmi\MksTheme\View\ThemeViewFinder;

class MksThemeServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('view.finder', function ($app) {
            $paths = $app['config']['view.paths'];

            return new ThemeViewFinder($app['files'], $paths);
        });

        $this->app->singleton(Theme::class, function ($app) {
            return new Theme($app['view.finder'], $app['config']['theme.path']);
        });

        $this->app->alias(Theme::class, 'theme');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/theme.php' => config_path('theme.php'),
        ], 'config');

        if ($theme = $this->app['config']['theme.name']) {
            $this->app[Theme::class]->set($theme);
        }
    }

    public function provides()
    {
        return [
            Theme::class,
        ];
    }
}