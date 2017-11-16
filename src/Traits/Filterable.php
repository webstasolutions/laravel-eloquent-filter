<?php

namespace WebstaSolutions\LaravelEloquentFilter\Traits;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use WebstaSolutions\LaravelEloquentFilter\Helpers;

trait Filterable
{
    /**
     * @param Request $request
     * @return Builder
     */
    public static function filterByRequest(Request $request, string $prefix = null)
    {
        return self::query()->filterByRequest($request, $prefix);
    }

    public static function renderFilter(string $columnName, bool $label = true, string $prefix = null) {
        $instance = new self();
        $filterSettings = $instance->filterSettings()[$columnName];
        $settings = isset($filterSettings['settings']) ? $filterSettings['settings'] : [];
        $filter = new $filterSettings['filter']($settings);
        $filter->setBuilder(self::query());
        $filter->setColumnName($columnName);
        return $filter->render($label, $prefix);
    }

    public static function renderFilterTableRow(array $columns, string $prefix = null) {
        return view('laravel_eloquent_filter::table-row', [
            'columns' => $columns,
            'model' => self::class,
            'prefix' => $prefix
        ]);
    }

    public static function renderResetButton(string $prefix = null) {
        return view('laravel_eloquent_filter::reset-button', [
           'prefix' => $prefix ?: Helpers::getModelName(self::class)
        ]);
    }

    public static function renderFilterButton(string $prefix = null) {
        return view('laravel_eloquent_filter::filter-button');
    }
}