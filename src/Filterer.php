<?php

namespace WebstaSolutions\LaravelEloquentFilter;


use \Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class Filterer
{
    /**
     * @var Builder
     */
    private $builder;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function filterByRequest(Request $request) {
        return $this->builder;
    }
}