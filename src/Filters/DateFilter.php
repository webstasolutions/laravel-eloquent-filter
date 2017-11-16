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

    protected function filter(Request $request, string $prefix = null)
    {
        $from = Helpers::getInputValue($this->getFilterName($prefix) . '_from', $request);
        $to = Helpers::getInputValue($this->getFilterName($prefix) . '_to', $request);
        if(!empty($from)) {
            $this->builder = $this->builder->whereDate($this->columnName, '>=', $from);
        }
        if(!empty($to)) {
            $this->builder = $this->builder->whereDate($this->columnName, '<=', $to);
        }
        return $this->builder;
    }

    public function render(bool $label, string $prefix = null)
    {
        return view($this->settings['view'], [
            'name' => $this->getFilterName($prefix),
            'valueFrom' => Helpers::getInputValue($this->getFilterName($prefix) . '_from'),
            'valueTo' => Helpers::getInputValue($this->getFilterName($prefix) . '_to'),
            'label' => $label ? (isset($this->settings['label']) ? $this->settings['label'] : (isset($this->settings['label_trans']) ? trans($this->settings['label_trans']) : null)) : null
        ]);
    }
}