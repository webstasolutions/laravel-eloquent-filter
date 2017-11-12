<?php

namespace WebstaSolutions\LaravelEloquentFilter;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Filter
{
    /**
     * @var array
     */
    protected $defaultSettings = [];

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
    private $modelName = '';

    /**
     * @var string
     */
    protected $relationName = '';

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
     * @return Builder
     */
    public function _filter(Request $request, string $prefix = null)
    {
        $relationsArray = explode('.', $this->columnName);
        if (count($relationsArray) > 1) {
            $this->setColumnName(array_pop($relationsArray));
            $relation = implode('.', $relationsArray);
            return $this->builder->whereHas($relation, function ($query) use (&$request, &$prefix, &$relation) {
                $this->builder = $query;
                $this->relationName = $relation;
                $this->filter($request, $prefix);
            });
        }
        return $this->filter($request, $prefix);
    }

    public function getFilterName(string $prefix = null)
    {
        if (!isset($prefix)) {
            $prefix = $this->modelName;
        }
        return str_replace('.', '_', $prefix . '_' . ($this->relationName !== '' ? $this->relationName . '_' : '') . $this->columnName);
    }

    /**
     * @param Request $request
     * @return Builder
     */
    protected abstract function filter(Request $request, string $prefix = null);

    /**
     * @return string
     */
    public function render(bool $label, string $prefix = null)
    {
        $request = request();
        return view($this->settings['view'], [
            'name' => $this->getFilterName($prefix),
            'value' => $request->get($this->getFilterName($prefix)),
            'label' => $label ? (isset($this->settings['label']) ? $this->settings['label'] : (isset($this->settings['label_trans']) ? trans($this->settings['label_trans']) : null)) : null
        ]);
    }
}