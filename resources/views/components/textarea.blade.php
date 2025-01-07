<div class="form-group mb-3">
    <label for="{{ $id }}">{{ $label }}</label>
    <textarea id="{{ $id }}" name="{{ $name }}" class="form-control" placeholder="{{ $placeholder }}"
        @if ($required) required @endif>{{ old($name, $value ?? '') }}</textarea>
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
