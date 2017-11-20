<?php

namespace WebstaSolutions\LaravelEloquentFilter;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use WebstaSolutions\LaravelEloquentFilter\Exceptions\NoFilterSettingsException;

class Helpers
{
    public static function getModelName($model)
    {
        $fullName = is_string($model) ? $model : get_class($model);
        $explodedModelClassName = explode('\\', $fullName);
        return strtolower(end($explodedModelClassName));
    }

    public static function getInputValue(string $inputName, Request $request = null)
    {
        if (!isset($request)) {
            $request = request();
        }
        $value = $request->get($inputName);
        if (config('laravel_eloquent_filter.use_session')) {
            if ($value === null && $request->get('filter_submit') === null) {
                $value = $request->session()->get($inputName);
            }
            $request->session()->put($inputName, $value);
        }
        return $value;
    }

    public static function getFilterLabel(string $column, $model = null, array $filterSettings = null)
    {
        if($column == '') return '';
        if(!isset($filterSettings)) {
            try {
                $instance = new $model();
                $filterSettings = $instance->filterSettings()[$column]['settings'];
            } catch (Exception $ex) {
                throw new NoFilterSettingsException($model);
            }
            if(!is_array($filterSettings)) {
                throw new NoFilterSettingsException($model);
            }
        }
        return isset($filterSettings['label']) ? $filterSettings['label'] : (isset($filterSettings['label_trans']) ? trans($filterSettings['label_trans']) : null);
    }
}