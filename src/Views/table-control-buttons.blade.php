<form class="table-filter-controls" id="table-filter-controls-{{ $prefix }}">
    {!! $model::renderPerPageSelect($prefix) !!}
    {!! $model::renderFilterResetButton($prefix) !!}
    {!! $model::renderFilterButton($prefix) !!}
</form>