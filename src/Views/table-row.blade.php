<tr>
    @foreach($columns as $column)
        <td>
            @if($column !== '')
                {!! $model::renderFilter($column, false, $prefix) !!}
            @endif
        </td>
    @endforeach
    <td>
        <form>
            <input type="submit" class="btn btn-primary" value="@lang('laravel_eloquent_filter::filter.filter')">
            {!! $model::renderResetButton($prefix) !!}
        </form>
    </td>
    <script>
        (function() {
            var tr = document.scripts[document.scripts.length - 1].parentNode;
            var forms = tr.getElementsByTagName('form');
            var form = forms[forms.length - 1];
            form.addEventListener('submit', function (e) {
                var inputs = tr.querySelectorAll('[data-eloquent-filter]');
                inputs.forEach(function (input) {
                    if(input.value !== '') {
                        var hidden = document.createElement('input');
                        hidden.type = 'hidden';
                        hidden.name = input.name;
                        hidden.value = input.value;
                        var isCheckbox = input.type === 'checkbox' || input.type === 'radio';
                        if(!isCheckbox || (isCheckbox && input.checked)) {
                            form.appendChild(hidden);
                        }
                    }
                })
            });
        })();
    </script>
</tr>