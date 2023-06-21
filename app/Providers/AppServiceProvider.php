<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Blade::directive('svg', function ($expression) {
            $args = explode(',', $expression);
            $icon = trim($args[0], "'\"");
            $fill = isset($args[1]) ? trim(str_replace(' ', '', $args[1]), "'\"") : 'none';
            $stroke = isset($args[2]) ? trim(str_replace(' ', '', $args[2]), "'\"") : 'none';
            $path = resource_path('svg/' . $icon . '.svg');
            if (File::exists($path)) {
                $svg = File::get($path);
                $svg = str_replace('fill="none"', "fill=\"$fill\"", $svg);
                $svg = str_replace('fill="currentColor"', "fill=\"$fill\"", $svg);
                $svg = str_replace('stroke="none"', "stroke=\"$stroke\"", $svg);
                $svg = str_replace('stroke="currentColor"', "stroke=\"$stroke\"", $svg);
                return $svg;
            }
            return '';
        });

    }
}