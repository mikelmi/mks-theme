## Theme Support for Laravel 5

This package supports the management view files and assets under separate folders in Laravel projects.

## Installation

1. Installation with
```
    composer require mikelmi/mks-theme:dev-master
```
2. Add the service provider in `config/app.php`, to `providers`:
```
    Mikelmi\MksTheme\Providers\MksThemeServiceProvider::class,
```    
3. Add Facade alias in `config/app.php`, to `aliases`:
```
    'Theme' => Mikelmi\MksTheme\Facades\Theme::class,
```
4. Publish config
```    
    php artisan vendor:publish --provider="Mikelmi\MksTheme\Providers\MksThemeServiceProvider"
```

## Create/configure theme

1. Create new folder in `public/themes/`, for example `public/themes/cool-theme`
2. Set your theme in `config/theme.php`:
```
    'name' => 'cool-theme'
    ...
```    
3. Now you can overwrite any view from `resources/views` within the folder `public/themes/cool-theme/views`

## Usage
```
    Theme::set('theme-name');          // switch to 'theme-name'
    Theme::get();                      // retrieve current theme's name
    Theme::all();                      // retrieve collection with all themes
    Theme::asset('assets/path')        // retrieve url to theme asset (e.g.: Theme::asset('assets/css/styles.css')) 
    Theme::info('key'/** or null */);  // retrive theme info (from file /themes/theme-name/theme.php)
    
```
