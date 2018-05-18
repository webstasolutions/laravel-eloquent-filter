<?php

namespace WebstaSolutions\LaravelEloquentFilter;


use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
        $this->publishes([
            __DIR__.'/Config/laravel_eloquent_filter.php' => config_path('laravel_eloquent_filter.php'),
        ], 'config');
        $this->publishes([
            __DIR__.'/Views' => resource_path('views/vendor/laravel_eloquent_filter'),
        ], 'templates');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        Builder::macro('filterByRequest', function (Request $request = null, string $prefix = null, bool $paginate = true, bool $sort = true, string $defaultSort = null, string $defaultSortOrder = null) {
            $filterer = new Filterer($this);
            return $filterer->filterByRequest($request, $prefix, $paginate, $sort, $defaultSort, $defaultSortOrder);
        });

        Builder::macro('filterByArray', function (array $array) {
            $filterer = new Filterer($this);
            return $filterer->filterByArray($array);
        });
    }
}