<tr>
    @foreach($columns as $column)
        <td>
            @if($column !== '')
                {!! $model::renderFilter($column, $prefix, false, true) !!}
            @endif
        </td>
    @endforeach
    <td></td>
    <script>
        (function () {
            var form = document.getElementById('table-filter-controls-{{ $prefix }}');
            if (typeof form === 'null') {
                var tr = document.scripts[document.scripts.length - 1].parentNode;
                var forms = tr.getElementsByTagName('form');
                form = forms[forms.length - 1];
            }
            form.addEventListener('submit', function (e) {
                var inputs = document.querySelectorAll('[data-eloquent-filter][name*={{ $prefix }}_]');
                inputs.forEach(function (input) {
                    if (input.value !== '') {
                        var hidden = document.createElement('input');
                        hidden.type = 'hidden';
                        hidden.name = input.name;
                        hidden.value = input.value;
                        var isCheckbox = input.type === 'checkbox' || input.type === 'radio';
                        if (!isCheckbox || (isCheckbox && input.checked)) {
                            form.appendChild(hidden);
                        }
                    }
                })
            });
        })();
    </script>
</tr>