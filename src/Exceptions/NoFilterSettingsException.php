<?php

namespace WebstaSolutions\LaravelEloquentFilter\Exceptions;


use Illuminate\Database\Eloquent\Model;
use Throwable;

class NoFilterSettingsException extends \Exception
{

    public function __construct(Model $model, Throwable $previous = null)
    {
        $message = 'The model ' . get_class($model) . ' has no or wrong filter settings.';
        parent::__construct($message, 0, $previous);
    }
}