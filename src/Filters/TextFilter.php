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

    protected function filter(array $values)
    {
        if (isset($this->settings['columns']) && !empty($this->settings['columns'])) {
            return $this->builder->where(function ($query) use ($values) {
                foreach ($this->settings['columns'] as $column) {
                    $query = $query->orWhere($column, 'LIKE', '%' . $values[0] . '%');
                }
            });
        }
        
        return $this->builder->where($this->columnName, 'LIKE', '%' . $values[0] . '%');
    }
}