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
    public static function filterByRequest(Request $request, string $prefix = null, bool $paginate = true)
    {
        return self::query()->filterByRequest($request, $prefix, $paginate);
    }

    public static function renderFilter(string $columnName, string $prefix = null, bool $label = true, bool $reset = false) {
        $instance = new self();
        $filterSettings = $instance->filterSettings()[$columnName];
        $settings = isset($filterSettings['settings']) ? $filterSettings['settings'] : [];
        $filter = new $filterSettings['filter']($settings);
        $filter->setBuilder(self::query());
        $filter->setColumnName($columnName);
        return $filter->render($prefix, $label, $reset);
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
        return view('laravel_eloquent_filter::filter-button', [
            'prefix' => $prefix ?: Helpers::getModelName(self::class)
        ]);
    }

    public static function renderPerPageSelect(string $prefix = null) {
        $realPrefix = $prefix ?: Helpers::getModelName(self::class);
        return view('laravel_eloquent_filter::per-page-select', [
            'prefix' => $realPrefix,
            'value' => Helpers::getInputValue($realPrefix . '_per_page'),
            'total' => self::count()
        ]);
    }
}