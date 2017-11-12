<?php

namespace WebstaSolutions\LaravelEloquentFilter;


use Illuminate\Database\Eloquent\Model;

class Helpers
{
    public static function getModelName($model) {
        $fullName = is_string($model) ? $model : get_class($model);
        $explodedModelClassName = explode('\\', $fullName);
        return strtolower(end($explodedModelClassName));
    }
}