<div class="form-group">
    @if(isset($label))
        <label class="label-control">{{ $label }}
        </label>
    @endif
    <div class="dropdown" style="margin-bottom: 10px;">
        <button class="btn btn-default glyphicon glyphicon-filter dropdown-toggle" data-toggle="dropdown"></button>
        <ul class="dropdown-menu" style="padding: 0 10px 10px;">
            @foreach($values as $key => $value)
                <li class="checkbox">
                    <label>
                        <input data-eloquent-filter
                               type="checkbox"
                               name="{{ $name }}[]"
                               value="{{ $key }}"
                               @if(in_array($value, $selectedValues)) checked="checked" @endif>
                        {{ $value }}
                    </label>
                </li>
            @endforeach
            <li>
                <button class="btn btn-danger {{ $name }}_reset">@lang('laravel_eloquent_filter::filter.reset')</button>
            </li>
        </ul>
    </div>
    @if(!empty($selectedValues))
        <p>
            @foreach($selectedValues as $selectedValue)
                {{ $selectedValue }}
            @endforeach
        </p>
    @endif
    <script>
        (function () {
            var filter = document.scripts[document.scripts.length - 1].parentNode;
            var dropdown = filter.getElementsByClassName('dropdown-menu')[0];
            dropdown.addEventListener('click', function (e) {
                e.stopPropagation();
            });
            var resetButton = filter.getElementsByClassName("{{ $name }}_reset")[0];
            resetButton.addEventListener('click', function (e) {
                e.preventDefault();
                var inputs = filter.querySelectorAll('input[type=checkbox]');
                inputs.forEach(function (input) {
                    input.checked = false;
                });
            });
        })();
    </script>
</div>