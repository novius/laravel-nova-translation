<?php

namespace Novius\LaravelNovaTranslation;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class LaravelNovaTranslationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::resources([
                config('laravel-nova-translation.language_line_resource'),
            ]);
        });

        $packageDir = dirname(__DIR__);

        $this->publishes([$packageDir.'/config' => config_path()], 'config');

        $this->loadTranslationsFrom($packageDir.'/resources/lang', 'laravel-nova-translation');
        $this->publishes([__DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-nova-translation')], 'lang');
    }
}
