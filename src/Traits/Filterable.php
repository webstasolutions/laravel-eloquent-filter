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
    public static function filterByRequest(Request $request = null, string $prefix = null, bool $paginate = true, bool $sort = true, string $defaultSort = null, string $defaultSortOrder = null)
    {
        return self::query()->filterByRequest($request, $prefix, $paginate, $sort, $defaultSort, $defaultSortOrder);
    }

    public static function filterByArray(array $array)
    {
        return self::query()->filterByArray($array);
    }

    public static function renderFilter(string $columnName, string $prefix = null, bool $label = true, bool $reset = false)
    {
        $instance = new self();
        $filterSettings = $instance->filterSettings()[$columnName];
        $settings = isset($filterSettings['settings']) ? $filterSettings['settings'] : [];
        $filter = new $filterSettings['filter']($settings);
        $filter->setBuilder(self::query());
        $filter->setColumnName($columnName);
        return $filter->_render($prefix, $label, $reset);
    }

    public static function renderFilterTableRow(array $columns, string $prefix = null)
    {
        $realPrefix = $prefix ?: Helpers::getModelName(self::class);
        return view('laravel_eloquent_filter::table-row', [
            'columns' => $columns,
            'model' => self::class,
            'prefix' => $realPrefix
        ]);
    }

    public static function renderFilterTableHead(array $columns, string $prefix = null)
    {
        $realPrefix = $prefix ?: Helpers::getModelName(self::class);
        return view('laravel_eloquent_filter::table-head', [
            'settings' => array_map(function($column) {
                if (empty($column)) return '';
                return Helpers::getFilterThSettings($column, self::class);
            }, $columns),
            'model' => self::class,
            'prefix' => $realPrefix,
            'columns' => $columns,
            'filterRow' => self::renderFilterTableRow($columns, $prefix)
        ]);
    }

    public static function renderFilterControlButtons(string $prefix = null)
    {
        $realPrefix = $prefix ?: Helpers::getModelName(self::class);
        return view('laravel_eloquent_filter::table-control-buttons', [
            'model' => self::class,
            'prefix' => $realPrefix
        ]);
    }

    public static function renderFilterResetButton(string $prefix = null)
    {
        $realPrefix = $prefix ?: Helpers::getModelName(self::class);

        if (Helpers::isFiltersActive($realPrefix, self::class)) {
            return view('laravel_eloquent_filter::reset-button', [
                'prefix' => $realPrefix,
            ]);
        } else {
            return null;
        }
    }

    public static function renderFilterButton(string $prefix = null)
    {
        $realPrefix = $prefix ?: Helpers::getModelName(self::class);
        return view('laravel_eloquent_filter::filter-button', [
            'prefix' => $realPrefix
        ]);
    }

    public static function renderPerPageSelect(string $prefix = null)
    {
        $realPrefix = $prefix ?: Helpers::getModelName(self::class);
        return view('laravel_eloquent_filter::per-page-select', [
            'prefix' => $realPrefix,
            'value' => Helpers::getInputValue($realPrefix . '_per_page'),
            'total' => self::count()
        ]);
    }

    public static function renderSortingButtons(string $columnName, string $prefix = null)
    {
        $instance = new self();
        $filterSettings = $instance->filterSettings()[$columnName];
        $settings = isset($filterSettings['settings']) ? $filterSettings['settings'] : [];
        $filter = new $filterSettings['filter']($settings);
        return $filter->_renderSortingButtons($columnName, $prefix);
    }
}