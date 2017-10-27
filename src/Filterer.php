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

    /**
     * @param Request $request
     * @return Builder
     */
    public function filterByRequest(Request $request, string $prefix = null)
    {
        $model = $this->builder->getModel();
        if(!is_array($model->filterSettings)) {
            throw new NoFilterSettingsException($model);
        }
        foreach ($model->filterSettings as $column => $filterSetting) {
            if(!isset($filterSetting['filter'])) {
                throw new NoFilterSettingsException($model);
            }
            $settings = isset($filterSetting['settings']) ? $filterSetting['settings'] : [];
            $filter = new $filterSetting['filter']($settings);
            $filter->setBuilder($this->builder);
            $filter->setColumnName($column);
            $this->builder = $filter->filter($request, $prefix);
        }
        return $this->builder;
    }
}