<?php

namespace WebstaSolutions\LaravelEloquentFilter\Filters;


use Illuminate\Http\Request;
use WebstaSolutions\LaravelEloquentFilter\Filter;

class TextFilter extends Filter
{
    protected $defaultSettings = [
        'view' => 'laravel_eloquent_filter::text-filter'
    ];

    public function filter(Request $request, string $prefix = null)
    {
        parent::filter($request, $prefix);
        return $this->builder->where($this->columnName, 'LIKE', '%' . $request->get($this->getFilterName($prefix)) . '%');
    }
}