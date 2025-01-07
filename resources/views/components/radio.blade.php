<div class="custom-control custom-radio mb-3">
    <input type="radio" id="{{ $id }}" name="{{ $name }}" class="custom-control-input {{ $class ?? '' }}"
           value="{{ $value ?? '' }}" @if (old($name, $value ?? '') == $value) checked @endif @if ($required) required @endif>
    <label class="custom-control-label" for="{{ $id }}">{{ $label }}</label>
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
