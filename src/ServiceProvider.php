<?php

namespace WebstaSolutions\LaravelEloquentFilter;


use \Illuminate\Database\Eloquent\Builder;
use \Illuminate\Http\Request;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/Views', 'laravel_eloquent_filter');
        $this->loadTranslationsFrom(__DIR__.'/Translations', 'laravel_eloquent_filter');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        Builder::macro('filterByRequest', function (Request $request, string $prefix = null) {
            $filterer = new Filterer($this);
            return $filterer->filterByRequest($request, $prefix);
        });
    }
}