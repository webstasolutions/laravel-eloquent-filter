<?php

namespace WebstaSolutions\LaravelEloquentFilter\Filters;


use Illuminate\Http\Request;
use WebstaSolutions\LaravelEloquentFilter\Filter;

class DateFilter extends Filter
{
    protected $defaultSettings = [
        'view' => 'laravel_eloquent_filter::Filters.date-filter'
    ];

    protected function filter(Request $request, string $prefix = null)
    {
        $from = $request->get($this->getFilterName($prefix) . '_from');
        $to = $request->get($this->getFilterName($prefix) . '_to');
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
        $request = request();
        return view($this->settings['view'], [
            'name' => $this->getFilterName($prefix),
            'valueFrom' => $request->get($this->getFilterName($prefix) . '_from'),
            'valueTo' => $request->get($this->getFilterName($prefix) . '_to'),
            'label' => $label ? (isset($this->settings['label']) ? $this->settings['label'] : (isset($this->settings['label_trans']) ? trans($this->settings['label_trans']) : null)) : null
        ]);
    }
}