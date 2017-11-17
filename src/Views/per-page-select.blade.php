<div class="form-group">
    <label class="control-label">@lang('laravel_eloquent_filter::filter.per_page') ({{ $total }})</label>
    <select name="{{ $prefix }}_per_page" value="{{ $value }}">
        @foreach([10, 25, 50, 100] as $val)
            <option value="{{ $val }}" @if($val == $value) selected @endif>{{ $val }}</option>
        @endforeach
    </select>
</div>