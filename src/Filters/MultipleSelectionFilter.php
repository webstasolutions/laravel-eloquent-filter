<?php

namespace WebstaSolutions\LaravelEloquentFilter\Filters;


use Illuminate\Http\Request;
use WebstaSolutions\LaravelEloquentFilter\Filter;
use WebstaSolutions\LaravelEloquentFilter\Helpers;

class MultipleSelectionFilter extends Filter
{
    protected $defaultSettings = [
        'view' => 'laravel_eloquent_filter::Filters.multiple-selection-filter',
        'values' => 'db'
    ];

    protected function filter(array $values)
    {
        $conditions = $values[0];
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

    public function render(array $templateData)
    {
        $checkboxValues = [];
        if ($this->settings['values'] == 'db') {
            $relationsArray = explode('.', $this->columnName);
            if (count($relationsArray) > 1) {
                $this->setColumnName(array_pop($relationsArray));
                $relation = implode('.', $relationsArray);
                //$this->relationName = $relation;
                $this->builder->whereHas($relation, function ($query) use (&$prefix) {
                    $this->builder = $query;
                });
            }
            $distinct = $this->builder->getModel()::query()->select($this->columnName)->distinct()->pluck($this->columnName)->toArray();
            $checkboxValues = array_combine($distinct, $distinct);
        } else {
            $checkboxValues = $this->settings['values'];
        }
        $templateData['checkboxValues'] = $checkboxValues;
        $values = $templateData['values'][0] ?: [];
        if($this->settings['values'] == 'db') {
            $values = array_combine($values, $values);
        } else {
            $newArray = [];
            foreach($values as $selectedValue) {
                $newArray[$selectedValue] = $this->settings['values'][$selectedValue];
            }
            $values = $newArray;
        }
        $templateData['values'][0] = $values;
        return view($this->settings['view'], $templateData);
    }
}