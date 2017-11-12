<div class="form-group">
    <label class="label-control" for="{{ $name }}_from">@if(isset($label)){{ $label }}@endif @lang('laravel_eloquent_filter::filter.from')</label>
    <input data-eloquent-filter type="date" name="{{ $name }}_from" id="{{ $name }}_from" value="{{ $valueFrom }}" class="form-control"/>
</div>
<div class="form-group">
    <label class="label-control" for="{{ $name }}_to">@if(isset($label)){{ $label }}@endif @lang('laravel_eloquent_filter::filter.to')</label>
    <input data-eloquent-filter type="date" name="{{ $name }}_to" id="{{ $name }}_to" value="{{ $valueTo }}" class="form-control"/>
</div>