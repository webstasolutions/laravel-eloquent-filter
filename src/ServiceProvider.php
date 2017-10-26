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

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        Builder::macro('filterByRequest', function(Request $request) {
            $filterer = new Filterer($this);
            return $filterer->filterByRequest($request);
        });
    }
}