<thead>
<tr>
    @foreach($labels as $label)
        <th>{{ $label }}</th>
    @endforeach
    <th></th>
</tr>
</thead>
{!! $filterRow !!}