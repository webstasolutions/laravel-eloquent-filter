<?php

namespace WebstaSolutions\LaravelEloquentFilter\Filters;


use Illuminate\Http\Request;
use WebstaSolutions\LaravelEloquentFilter\Filter;
use WebstaSolutions\LaravelEloquentFilter\Helpers;

class TextFilter extends Filter
{
    protected $defaultSettings = [
        'view' => 'laravel_eloquent_filter::Filters.text-filter'
    ];

    protected function filter(Request $request, string $prefix = null)
    {
        return $this->builder->where($this->columnName, 'LIKE', '%' . Helpers::getInputValue($this->getFilterName($prefix), $request) . '%');
    }
}