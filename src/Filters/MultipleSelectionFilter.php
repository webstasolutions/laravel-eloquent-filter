<?php

namespace WebstaSolutions\LaravelEloquentFilter\Filters;


use Illuminate\Http\Request;
use WebstaSolutions\LaravelEloquentFilter\Filter;

class MultipleSelectionFilter extends Filter
{
    protected $defaultSettings = [
        'view' => 'laravel_eloquent_filter::multiple-selection-filter',
        'values' => 'db'
    ];

    protected function filter(Request $request, string $prefix = null)
    {
        $conditions = $request->get($this->getFilterName($prefix));
        if (is_array($conditions)) {
            $this->builder = $this->builder->where(function ($query) use (&$conditions) {
                $query->where($this->columnName, $conditions[0]);
                foreach(array_slice($conditions, 1) as $condition) {
                    $query->orWhere($this->columnName, $condition);
                }
            });
        }
        return $this->builder;
    }

    public function render(bool $label, string $prefix = null)
    {
        $values = [];
        if ($this->settings['values'] == 'db') {
            $relationsArray = explode('.', $this->columnName);
            if (count($relationsArray) > 1) {
                $this->setColumnName(array_pop($relationsArray));
                $relation = implode('.', $relationsArray);
                $this->builder->whereHas($relation, function ($query) use (&$request, &$prefix, &$relation) {
                    $this->builder = $query;
                    $this->relationName = $relation;
                });
            }
            $distinct = $this->builder->getModel()::query()->select($this->columnName)->distinct()->pluck($this->columnName)->toArray();
            $values = array_combine($distinct, $distinct);
        } else {
            $values = $this->settings['values'];
        }
        $request = request();
        $selectedValues = $request->get($this->getFilterName($prefix)) ?: [];
        if($this->settings['values'] == 'db') {
            $selectedValues = array_combine($selectedValues, $selectedValues);
        } else {
            $newArray = [];
            foreach($selectedValues as $selectedValue) {
                $newArray[$selectedValue] = $this->settings['values'][$selectedValue];
            }
            $selectedValues = $newArray;
        }
        return view($this->settings['view'], [
            'name' => $this->getFilterName($prefix),
            'values' => $values,
            'selectedValues' => $selectedValues,
            'label' => $label ? (isset($this->settings['label']) ? $this->settings['label'] : (isset($this->settings['label_trans']) ? trans($this->settings['label_trans']) : null)) : null
        ]);
    }
}