<?php

namespace WebstaSolutions\LaravelEloquentFilter\Filters;


use Illuminate\Http\Request;
use WebstaSolutions\LaravelEloquentFilter\Filter;
use WebstaSolutions\LaravelEloquentFilter\Helpers;

class DateFilter extends Filter
{
    protected $defaultSettings = [
        'view' => 'laravel_eloquent_filter::Filters.date-filter'
    ];

    public $values = [
        'from' => '_from',
        'to' => '_to'
    ];

    protected function filter(array $values)
    {
        $from = isset($values['from']) ? $values['from'] : '';
        $to = isset($values['to']) ? $values['to'] : '';
        if(!empty($from)) {
            $this->builder = $this->builder->where(function($q) use ($from) {
                $q->whereDate($this->columnName, '>=', $from)->orWhereNull($this->columnName);
            });
        }
        if(!empty($to)) {
            $this->builder = $this->builder->where(function($q) use ($to) {
                $q->whereDate($this->columnName, '<=', $to)->orWhereNull($this->columnName);
            });
        }
        return $this->builder;
    }
}