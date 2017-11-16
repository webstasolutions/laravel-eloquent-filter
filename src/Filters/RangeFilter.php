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

    public function render(bool $label, string $prefix = null)
    {
        $request = request();
        return view($this->settings['view'], [
            'name' => $this->getFilterName($prefix),
            'valueFrom' => $request->get($this->getFilterName($prefix) . '_from'),
            'valueTo' => $request->get($this->getFilterName($prefix) . '_to'),
            'label' => $label ? (isset($this->settings['label']) ? $this->settings['label'] : (isset($this->settings['label_trans']) ? trans($this->settings['label_trans']) : null)) : null
        ]);
    }
}