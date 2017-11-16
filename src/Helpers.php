<?php

namespace WebstaSolutions\LaravelEloquentFilter;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Helpers
{
    public static function getModelName($model) {
        $fullName = is_string($model) ? $model : get_class($model);
        $explodedModelClassName = explode('\\', $fullName);
        return strtolower(end($explodedModelClassName));
    }

    public static function getInputValue(string $inputName, Request $request = null) {
        if(!isset($request)) {
            $request = request();
        }
        $value = $request->get($inputName);
        if(config('laravel_eloquent_filter.use_session')) {
            if($value === null && $request->get('filter_submit') === null) {
                $value = $request->session()->get($inputName);
            }
            $request->session()->put($inputName, $value);
        }
        return $value;
    }
}