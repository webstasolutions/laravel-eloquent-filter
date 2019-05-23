<form id="table-filter-form">
    {!! $model::renderPerPageSelect($prefix) !!}
    {!! $model::renderFilterResetButton($prefix) !!}
    {!! $model::renderFilterButton($prefix) !!}
</form>