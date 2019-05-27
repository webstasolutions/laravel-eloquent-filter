@if(!empty($values[0]))
    <span class="fa fa-times" style="color: red" onclick="document.getElementById('{{$prefix}}_reset_filter').click()"></span><strong> Status: </strong>
    @foreach($values[0] as $value)
        {{ $value }}
    @endforeach
@endif

<thead>
<tr>
    @foreach($settings as $index => $setting)
        <th class="{{$setting['th_class']}}">
            @if (empty($setting['label']))
                &nbsp;
            @else
                {{ $setting['label'] }} {!! $model::renderSortingButtons($columns[$index], $prefix) !!}
            @endif
        </th>
    @endforeach
    <th></th>
</tr>
</thead>
{!! $filterRow !!}
<script>
    (function () {
        var form = document.getElementById('table-filter-controls-{{ $prefix }}');
        var parent = document.scripts[document.scripts.length - 1].parentNode.parentNode;
        if (typeof form === 'null') {
            var forms = parent.getElementsByTagName('form');
            form = forms[forms.length - 1];
        }
        var sortingButtons = parent.querySelectorAll('button[name="{{ $prefix }}_sorting"]');
        for(var i = 0; i < sortingButtons.length; i++) {
            (function () {
                var button = sortingButtons[i];
                button.addEventListener('click', function() {
                    var sortingHidden = document.getElementById('{{ $prefix }}_sorting');
                    if(!sortingHidden) {
                        sortingHidden = document.createElement('input');
                        sortingHidden.type = 'hidden';
                        sortingHidden.name = button.name;
                        form.append(sortingHidden);
                    }
                    sortingHidden.value = button.value;
                    form.querySelectorAll('#{{ $prefix }}_submit_filter')[0].click();
                });
            })();
        }
    })();
</script>
