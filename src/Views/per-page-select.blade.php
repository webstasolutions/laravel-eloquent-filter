<div class="form-group">
    <label class="control-label">@lang('laravel_eloquent_filter::filter.per_page') ({{ $total }})</label>
    <select name="{{ $prefix }}_per_page" value="{{ $value }}">
        @foreach([10, 25, 50, 100] as $val)
            <option value="{{ $val }}" @if($val == $value) selected @endif>{{ $val }}</option>
        @endforeach
    </select>
    <script>
        (function () {
            var select = document.querySelector('select[name="{{ $prefix }}_per_page"]');
            if(select.closest("form") === null || select.closest("form").id != 'table-filter-controls-{{ $prefix }}') {
                var input = document.createElement("input");
                input.type = "text";
                input.name = "{{ $prefix }}_per_page";
                input.hidden = true;
                input.value = '{{ $value }}';
                document.querySelector('#table-filter-controls-{{ $prefix }}').appendChild(input);
                select.addEventListener('change', function () {
                    input.value = this.value;
                    document.getElementById('{{ $prefix }}_submit_filter').click();
                    console.log(this.value);
                });
            }else {
                select.addEventListener('change', function () {
                    document.getElementById('{{ $prefix }}_submit_filter').click();
                });
            }
        })();
    </script>
</div>