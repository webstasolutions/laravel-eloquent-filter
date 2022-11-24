<div class="form-group">
    @if(isset($label))
        <label class="label-control" for="{{ $name }}_from">{{ $label }}</label>
    @endif
    <div class="input-group">
        <input type="date" id="{{$name}}_rangepicker" data-name="{{$name}}" class="form-control datepickerrange">
        <div class="input-group-addon cursor-pointer open-datepicker" data-bs-toggle><i class="fa fa-calendar"></i></div>
    </div>
    <input data-eloquent-filter type="hidden" name="{{ $name }}_from" id="{{ $name }}_from" value="{{ $values['from'] }}" placeholder="@lang('laravel_eloquent_filter::filter.from')" class="form-control"/>
    <input data-eloquent-filter type="hidden" name="{{ $name }}_to" id="{{ $name }}_to" value="{{ $values['to'] }}" placeholder="@lang('laravel_eloquent_filter::filter.to')" class="form-control"/>
</div>
@if($reset && ($values['from'] || $values['to']))
    <div class="form-group">
        <button class="btn btn-danger" onclick="
                document.getElementById('{{ $name }}_from').value = '';
                document.getElementById('{{ $name }}_to').value = '';
                document.getElementById('{{ $prefix }}_submit_filter').click()
                ">@lang('laravel_eloquent_filter::filter.reset')</button>
    </div>
@endif