<div class="form-group">
    @if(isset($label))
        <label class="label-control" for="{{ $name }}">{{ $label }}</label>
    @endif
    <input type="text" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}" class="form-control"/>
</div>