<?php

namespace WebstaSolutions\LaravelEloquentFilter;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use WebstaSolutions\LaravelEloquentFilter\Helpers;

abstract class Filter
{
    /**
     * @var array
     */
    protected $defaultSettings = [];

    /**
     * @var array
     */
    protected $values = [''];

    /**
     * @var array
     */
    protected $settings = [];

    /**
     * @var Builder
     */
    protected $builder = null;

    /**
     * @var string
     */
    protected $columnName = null;

    /**
     * @var string
     */
    protected $modelName = '';

    /**
     * @var string
     */
    //protected $relationName = '';

    /**
     * Filter constructor.
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->settings = $settings;
        foreach ($this->defaultSettings as $key => $value) {
            if (!isset($this->settings[$key])) {
                $this->settings[$key] = $value;
            }
        }
    }

    /**
     * @param Builder $builder
     */
    public function setBuilder(Builder $builder)
    {
        $this->builder = $builder;
        if (!isset($this->settings['prefix'])) {
            $this->modelName = Helpers::getModelName($this->builder->getModel());
        } else {
            $this->modelName = $this->settings['prefix'];
        }
    }

    /**
     * @param string $columnName
     */
    public function setColumnName(string $columnName)
    {
        $this->columnName = $columnName;
    }

    /**
     * @param Request $request
     * @param string $prefix
     * @return Builder
     */
    public function _filterByRequest(Request $request, string $prefix = null)
    {
        $values = array_map(function ($suffix) use (&$prefix, &$request) {
            return Helpers::getInputValue($this->getFilterName($prefix) . $suffix, $request);
        }, $this->values);
        return $this->_filterByValues($values);
    }

    public function _filterByValues(array $values)
    {
        if (count($values) === 0) $values[0] = null;
        $relationsArray = explode('.', $this->columnName);
        if (count($relationsArray) > 1) {
            $this->setColumnName(array_pop($relationsArray));
            $relation = implode('.', $relationsArray);
            return $this->builder->whereHas($relation, function ($query) use (&$values, &$prefix) {
                $this->builder = $query;
                $this->filter($values);
            });
        }
        return $this->filter($values);
    }

    public function _render(string $prefix = null, bool $label, bool $reset)
    {
        $values = array_map(function ($suffix) use (&$prefix) {
            return Helpers::getInputValue($this->getFilterName($prefix) . $suffix);
        }, $this->values);
        if (count($values) === 0) $values[0] = null;
        $templateData = [
            'prefix' => $prefix ?: $this->modelName,
            'name' => $this->getFilterName($prefix),
            'values' => $values,
            'label' => $label ? Helpers::getFilterLabel($this->columnName, null, $this->settings) : null,
            'reset' => $reset
        ];
        return $this->render($templateData);
    }

    public function getFilterName(string $prefix = null)
    {
        if (!isset($prefix)) {
            $prefix = $this->modelName;
        }
        return str_replace('.', '_', $prefix . '_' . $this->columnName);
    }

    /**
     * @param array $values
     * @return Builder
     */
    protected abstract function filter(array $values);

    /**
     * @param array $templateData
     * @return string
     */
    public function render(array $templateData)
    {
        return view($this->settings['view'], $templateData);
    }
}