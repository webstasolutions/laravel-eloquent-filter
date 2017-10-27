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
     * Filter constructor.
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->settings = $settings;
        foreach ($this->defaultSettings as $key => $value) {
            if(!isset($this->settings[$key])) {
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
        if(!isset($this->settings['prefix'])) {
            $explodedModelClassName = explode('\\', get_class($this->builder->getModel()));
            $this->modelName = strtolower(end($explodedModelClassName));
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

    public function getFilterName(string $prefix = null)
    {
        if(!isset($prefix)) {
            $prefix = $this->modelName;
        }
        return $prefix . '_' . $this->columnName;
    }

    /**
     * @param Request $request
     * @return Builder
     */
    public function filter(Request $request, string $prefix = null)
    {
        if($request->get($this->getFilterName($prefix)) !== null) {
            return $this->builder;
        }
    }

    /**
     * @return string
     */
    public function render(bool $label, string $prefix = null) {
        $request = request();
        return view($this->settings['view'], [
            'name' => $this->getFilterName($prefix),
            'value' => $request->get($this->getFilterName($prefix)),
            'label' => $label ? isset($this->settings['label']) ? $this->settings['label'] : isset($this->settings['label_trans']) ? trans($this->settings['label_trans']) : null : null
        ]);
    }
}