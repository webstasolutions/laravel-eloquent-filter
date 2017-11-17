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

    protected function filter(Request $request, string $prefix = null)
    {
        $from = Helpers::getInputValue($this->getFilterName($prefix) . '_from', $request);
        $to = Helpers::getInputValue($this->getFilterName($prefix) . '_to', $request);
        if(!empty($from)) {
            $this->builder = $this->builder->where($this->columnName, '>=', $from);
        }
        if(!empty($to)) {
            $this->builder = $this->builder->where($this->columnName, '<=', $to);
        }
        return $this->builder;
    }

    public function render(string $prefix = null, bool $label, bool $reset)
    {
        return view($this->settings['view'], [
            'prefix' => $prefix ?: $this->modelName,
            'name' => $this->getFilterName($prefix),
            'valueFrom' => Helpers::getInputValue($this->getFilterName($prefix) . '_from'),
            'valueTo' => Helpers::getInputValue($this->getFilterName($prefix) . '_to'),
            'label' => $label ? (isset($this->settings['label']) ? $this->settings['label'] : (isset($this->settings['label_trans']) ? trans($this->settings['label_trans']) : null)) : null,
            'reset' => $reset
        ]);
    }
}