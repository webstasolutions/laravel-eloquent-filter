<div class="form-group">
    @if(isset($label))
        <label class="label-control">{{ $label }}
        </label>
    @endif
    <div class="dropdown" style="margin-bottom: 10px;">
        <button class="btn btn-default dropdown-toggle fa fa-filter" data-toggle="dropdown" style="font-size: 18px"></button>
        <ul class="dropdown-menu" id="{{ $name }}_dropdown-menu" style="padding: 0 10px 10px;">
            @foreach($checkboxValues as $key => $value)
                <li class="checkbox">
                    <label>
                        <input data-eloquent-filter
                               type="checkbox"
                               name="{{ $name }}[]"
                               value="{{ $key }}"
                               @if(in_array($value, $values[0])) checked @endif>
                        {{ $value }}
                    </label>
                </li>
            @endforeach
            @if(!empty($values[0]))
                <li>
                    <button class="btn-x-s btn-danger" style="margin-bottom: 5px" id="{{ $name }}_clear">@lang('laravel_eloquent_filter::filter.clear')</button>
                </li>
            @endif
                <div class="row">
                    <li class="col-md-6">
                        <button class="btn-x-s btn-primary" style="margin-bottom: 5px" onclick="
                                document.getElementById('{{ $prefix }}_submit_filter').click();
                                "><span class="fa fa-filter"></span> @lang('laravel_eloquent_filter::filter.filter')</button>
                    </li>
                    <li class="col-md-6" style="margin-left: 16px">
                        <button class="btn-x-s btn-danger" onclick="
                                document.getElementById('{{ $prefix }}_reset_filter').click();
                                "><span class="fa fa-times"></span> @lang('laravel_eloquent_filter::filter.reset')</button>
                    </li>
                </div>
        </ul>
    </div>
    @if(!empty($values[0]))
        <p id="filtered-data" class="hidden">
            @foreach($values[0] as $value)
                {{ $value }}
            @endforeach
        </p>
    @endif
    @if($reset && !empty($values[0]))
        <div class="form-group">
            <button class="btn btn-danger" onclick="
                    document.getElementById('{{ $name }}_clear').click();
                    document.getElementById('{{ $prefix }}_submit_filter').click();
                    return false;
                    "><span class="fa fa-times"></span> @lang('laravel_eloquent_filter::filter.reset')</button>
        </div>
    @endif
    <script>
        (function () {
            var dropdown = document.getElementById('{{ $name }}_dropdown-menu');
            if (dropdown) {

                dropdown.addEventListener('click', function (e) {
                    e.stopPropagation();
                });
                var resetButton = document.getElementById("{{ $name }}_clear");
                if (resetButton) {
                    resetButton.addEventListener('click', function (e) {
                        e.preventDefault();
                        var inputs = dropdown.querySelectorAll('input[type=checkbox]');
                        inputs.forEach(function (input) {
                            input.checked = false;
                        });
                    });
                }
            }
        })();
    </script>
</div>