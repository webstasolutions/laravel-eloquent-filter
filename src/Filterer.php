<?php

namespace WebstaSolutions\LaravelEloquentFilter;


use \Illuminate\Http\Request;
use \Illuminate\Database\Eloquent\Builder;
use WebstaSolutions\LaravelEloquentFilter\Exceptions\NoFilterSettingsException;

class Filterer
{
    /**
     * @var Builder
     */
    private $builder;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    private function checkModel() {
        $model = $this->builder->getModel();
        try {
            if (!is_array($model->filterSettings())) {
                throw new NoFilterSettingsException($model);
            }
        } catch (\BadMethodCallException $e) {
            throw new NoFilterSettingsException($model);
        }
        return $model;
    }

    /**
     * @param Request $request
     * @return Builder
     */
    public function filterByRequest(Request $request, string $prefix = null, bool $paginate = true)
    {
        $model = $this->checkModel();
        foreach ($model->filterSettings() as $column => $filterSetting) {
            if (!isset($filterSetting['filter'])) {
                throw new NoFilterSettingsException($model);
            }
            $settings = isset($filterSetting['settings']) ? $filterSetting['settings'] : [];
            $filter = new $filterSetting['filter']($settings);
            $filter->setBuilder($this->builder);
            $filter->setColumnName($column);
            $this->builder = $filter->_filterByRequest($request, $prefix);
        }
        if($paginate) {
            return $this->builder->paginate(Helpers::getInputValue($prefix ?: Helpers::getModelName($model) . '_per_page'));
        }
        return $this->builder;
    }

    public function filterByArray(array $array)
    {
        $model = $this->checkModel();
        foreach ($array as $column => $values) {
            $filterSetting = $model->filterSettings()[$column];
            if (!isset($filterSetting['filter'])) {
                throw new NoFilterSettingsException($model);
            }
            $settings = isset($filterSetting['settings']) ? $filterSetting['settings'] : [];
            $filter = new $filterSetting['filter']($settings);
            $filter->setBuilder($this->builder);
            $filter->setColumnName($column);
            $this->builder = $filter->_filterByValues($values);
        }
        return $this->builder;
    }
}