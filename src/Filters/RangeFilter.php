<?php

namespace WebstaSolutions\LaravelEloquentFilter\Filters;


use Illuminate\Http\Request;
use WebstaSolutions\LaravelEloquentFilter\Filter;
use WebstaSolutions\LaravelEloquentFilter\Helpers;

class RangeFilter extends Filter
{
    protected $defaultSettings = [
        'view' => 'laravel_eloquent_filter::Filters.range-filter'
    ];

    protected $values = [
        'from' => '_from',
        'to' => '_to'
    ];

    protected function filter(array $values)
    {
        $from = isset($values['from']) ? $values['from'] : '';
        $to = isset($values['to']) ? $values['to'] : '';
        if(!empty($from)) {
            $this->builder = $this->builder->where($this->columnName, '>=', $from);
        }
        if(!empty($to)) {
            $this->builder = $this->builder->where($this->columnName, '<=', $to);
        }
        return $this->builder;
    }
}