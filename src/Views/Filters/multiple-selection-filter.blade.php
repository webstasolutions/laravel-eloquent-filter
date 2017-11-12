<div class="form-group">
    @if(isset($label))
        <label class="label-control">{{ $label }}
        </label>@endif
    @if(!empty($selectedValues))
        <p>
            @foreach($selectedValues as $selectedValue)
                {{ $selectedValue }}
            @endforeach
        </p>
    @endif
    @foreach($values as $key => $value)
        <div class="checkbox">
            <label>
                <input data-eloquent-filter
                       type="checkbox"
                       name="{{ $name }}[]"
                       value="{{ $key }}"
                       @if(in_array($value, $selectedValues)) checked="checked" @endif>
                {{ $value }}
            </label>
        </div>
    @endforeach
    <button class="btn btn-danger {{ $name }}_reset">@lang('laravel_eloquent_filter::filter.reset')</button>
    <script>
        (function() {
            var filter = document.scripts[document.scripts.length - 1].parentNode;
            var resetButton = filter.getElementsByClassName("{{ $name }}_reset")[0];
            resetButton.addEventListener('click', function(e) {
                e.preventDefault();
                var inputs = filter.querySelectorAll('input[type=checkbox]');
                inputs.forEach(function(input) {
                    input.checked = false;
                });
            });
        })();
    </script>
</div>