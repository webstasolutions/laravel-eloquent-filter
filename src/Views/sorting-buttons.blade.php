<div style="float: right">
    @if($sorting[0] === $columnName && $sorting[1] === 'desc')
        <button name="{{ $prefix . '_sorting' }}" value="{{ $columnName }}-asc" class="fa fa-sort-asc" style="background:none;border:none"></button>
    @elseif($sorting[0] === $columnName && $sorting[1] === 'asc')
        <button name="{{ $prefix . '_sorting' }}" value="{{ $columnName }}-desc" class="fa fa-sort-desc" style="background:none;border:none"></button>
    @else
        <button name="{{ $prefix . '_sorting' }}" value="{{ $columnName }}-asc" class="fa fa-sort" style="background:none;border:none"></button>
    @endif
</div>
@if($sorting[0] === $columnName)
    <input data-eloquent-filter type="hidden" id="{{ $prefix . '_sorting' }}" name="{{ $prefix . '_sorting' }}" value="{{ implode('-', $sorting) }}"/>
@endif