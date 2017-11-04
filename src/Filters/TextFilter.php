<?php

namespace WebstaSolutions\LaravelEloquentFilter\Filters;


use Illuminate\Http\Request;
use WebstaSolutions\LaravelEloquentFilter\Filter;

class TextFilter extends Filter
{
    protected $defaultSettings = [
        'view' => 'laravel_eloquent_filter::text-filter'
    ];

    protected function filter(Request $request, string $prefix = null)
    {
        return $this->builder->where($this->columnName, 'LIKE', '%' . $request->get($this->getFilterName($prefix)) . '%');
    }
}