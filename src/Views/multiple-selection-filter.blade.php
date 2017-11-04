<div class="form-group">
    <label class="label-control">@if(isset($label)){{ $label }}@endif</label>
    <p>
        @foreach($selectedValues as $selectedValue)
            {{ $selectedValue }}
        @endforeach
    </p>
    @foreach($values as $key => $value)
        <div class="checkbox">
            <label>
                <input type="checkbox"
                       name="{{ $name }}[]"
                       value="{{ $key }}"
                       @if(in_array($value, $selectedValues)) checked="checked" @endif>
                {{ $value }}
            </label>
        </div>
    @endforeach
</div>