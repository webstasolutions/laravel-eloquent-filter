# laravel-eloquent-filter

Laravel module for easy creating and using Eloquent filters.

## Requirements

* PHP 7.0.0+
* Laravel 5.5+ (tested)
* Bootstrap 3 (optional)
* Font Awesome (optional)

## Installation

**THIS PACKAGE IS NOT ON PACKAGIST YET**

Download with composer:
```bash
composer require webstasolutions/laravel-eloquent-filter
```

If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php
```php
WebstaSolutions\LaravelEloquentFilter\ServiceProvider::class,
```

Run
```bash
php artisan vendor:publish --provider="WebstaSolutions\LaravelEloquentFilter\ServiceProvider"
```

This also published views in resources/views/vendor/laravel_eloquent_filter folder. You can change these views, but if you update this module, you must check them for changes or override them with:

```bash
php artisan vendor:publish --provider="WebstaSolutions\LaravelEloquentFilter\ServiceProvider" --tag="templates" --force
```

## Usage

### Setting up

Laravel Eloquent Filter saves filter values into session by default. You can change that in config/laravel_eloquent_filter.php

```php
'use_session' => true
```
### In a model

Use WebstaSolutions\LaravelEloquentFilter\Traits\Filterable trait and add column settings to your model.

```php
use WebstaSolutions\LaravelEloquentFilter\Traits\Filterable;

class User extends Model
{
    use Filterable;

    public function filterSettings() {
        return [
            'name' => [
                'filter' => TextFilter::class,
                'settings' => [
                    'label_trans' => 'users.name'
                ]
            ],
            'role.name' => [
                'filter' => TextFilter::class,
                'settings' => [
                    'label' => 'Role',
                    'view' => 'filters.role_name_filter',
                ]
            ]
        ];
    }
}
```

Here I want to filter column *name*. First key in the configuration array is *filter*. The value is the Filter class which should be used for this column. By default there are 4 types of filters in the WebstaSolutions\LaravelEloquentFilter\Filters namespace, more on that later.\
The settings key takes the configuration of the specified filter. It is different for each type, but there is one compulsory key and that is *label* or *label_trans* (for translations). There is also one optional key - view, which is the blade template which should be rendered.

You can also filter by relationships by using dot notation. In this case I filter by the name column in the roles table.

### In a view

By using the Filterable trait, you get multiple methods on your model. Methods that start with *render* are used in your views. If you want to change the HTML generated by this module, you can do it in resources/view/vendor/laravel_eloquent_filter folder. The default HTML is made for projects that use Bootstrap.

Default GET parameters are prefixed by the name of the model. If you need to change this prefix (i.e. for multiple filtered lists on one page), you must add it as a parameter into the function call.

```php
<form>
{!! \App\User::renderFilter('name', 'new_prefix', false, true) !!}
{!! \App\User::renderFilterButton('new_prefix') !!}
{!! \App\User::renderFilterResetButton('new_prefix') !!}
</form>
```

*renderFilter* method takes one compulsory and three optional parameters. These are:
* column name as in the model settings
* (optional) new prefix for the GET parameter - default null (uses model name as prefix)
* (optional) show filter label - default true
* (optional) show reset button for this column - default false

You usually want to use this method in a form with renderFilterButton and renderFilterResetButton methods, which both takes new prefix as optional parameter.

```php
{!! \App\User::renderPerPageSelect('new_prefix') !!}
```

*renderPerPageSelect* method takes new prefix as optional parameter and creates select input for selecting how many records should be displayed in one list. It is used if you set the *paginate* parameter to true in a controller. Default numbers are 10, 25, 50, 100. You can change them in the *per-page-select.blade.php* view.

```php
{!! \App\User::renderSortingButtons('age', 'new_prefix') !!}
```

*renderSortingButtons* method takes column name as first and new prefix as optional second parameter. This methods renders buttons for sorting the records. It calls SQL ORDER BY, so it doesn't work with relations.

```php
{!! \App\User::renderFilterTableRow(['name', 'role.name'], 'new_prefix') !!}
```

```php
{!! \App\User::renderFilterTableHead(['name', 'role.name'], 'new_prefix') !!}
```

These two methods both render filters specified in first parameter (as an array) and buttons as a table row. The latter method also renders a table head with labels.

### In a controller

There are two methods you can use in controller. Both are available on the model and on the Eloquent query builder.

```php
$users = User::filterByRequest($request, 'new_prefix', false, true, 'default_sort_column', 'ASC');
```

First of them is *filterByRequest*. You usually want to use this one. It takes 6 optional parameters, which are:
* Illuminate\Http\Request instance
* the prefix of the GET parameters
* paginate parameter - if true, this method return a collection of records rather than Eloquent query builder - it paginates the result by the *per page* select. Default true.
* sort parameter - if true, the records are sorted with the use of the *renderSortingButtons* view method. Default true.
* default sort colum - column name for deafult sorting
* default sort order - 'ASC' or 'DESC'

```php
$users = User::filterByArray([
    'name' => ['James'],
    'role.name' => ['Admin']
]);
```

The second method is *filterByArray*. It takes one compulsory array of column => values. The values are also an array, because in some filter type you need more than one input. This method returns an Eloquent query builder.

## Filter types

Default filter types are in the WebstaSolutions\LaravelEloquentFilter\Filters namespace.

### TextFilter

This is the most simple filter. It is just a simple text input.

### RangeFilter

This filter creates two number inputs. It filters the results by the value between them. If you want to use *filterByArray* method with this type, be aware that the values array needs to have keys *from* and *to*.

```php
$users = User::filterByArray([
    'age' => ['from' => 18, 'to' => 30]
]);
```

### DateFilter

This type is the same as RangeFilter, but creates date inputs instead of number inputs.

### MultipleSelectionFilter

This filter renders a dropdown with multiple checkboxes with values to filter the result. You can optionally set the values in the filter's settings in your model. If you don't set them, they are automatically taken from the database.

```php
public function filterSettings()
{
    return [
        'gender' => [
            // custom values
            'filter' => MultipleSelectionFilter::class,
            'settings' => [
                'label_trans' => 'users.gender',
                'values' => [
                    'male' => __('users.gender_male'),
                    'female' => __('users.gender_female'),
                    'shemale' => __('users.gender_shemale'),
                    'unknown' => __('users.gender_unknown'),
                ]
            ]
        ],
        'user.name' => [
            // automatic values
            'filter' => MultipleSelectionFilter::class,
            'settings' => [
                'label' => 'User'
            ]
        ]
    ];
}
```

## Creating custom filters

Sometimes you need more than default filters. You can create your own filter by extending the WebstaSolutions\LaravelEloquentFilter\Filter class. You need to set the default settings of the filter by creating *defaultSettings* protected attribute.

```php
class CustomFilter extends Filter
{
    protected $defaultSettings = [
        'view' => 'laravel_eloquent_filter::Filters.date-filter'
    ];
}
```

If you need more than one value of you input, you can do this by setting the suffixes of these parameters.

```php
protected $values = [
    'from' => '_from',
    'to' => '_to'
];
```

Then you need to override the *filter* method, which takes values array as a parameter. You can get the column name in `$this->columnName` and the Eloquent builder in `$this->builder`.

```php
protected function filter(array $values)
{
    return $this->builder->where($this->columnName, 'LIKE', '%' . $values[0] . '%');
}
```

Optionally you want to override the *render* method, whick takes blade template data as a attribute. You can get the filter settings in `$this->settings`.

```php
public function render(array $templateData)
{
    return view($this->settings['view'], $templateData);
}
```

You can then use your new filter in the column settings in your model.
