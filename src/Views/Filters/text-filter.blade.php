<div class="form-group">
    @if(isset($label))
        <label class="label-control" for="{{ $name }}">{{ $label }}</label>
    @endif
    <input data-eloquent-filter type="text" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}" class="form-control"/>
</div>
@if($reset && $value)
    <div class="form-group">
        <button class="btn btn-danger" onclick="
                document.getElementById('{{ $name }}').value = '';
                document.getElementById('{{ $prefix }}_submit_filter').click()
                ">@lang('laravel_eloquent_filter::filter.reset')</button>
    </div>
@endif