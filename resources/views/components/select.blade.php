<div class="form-group mb-3">
    <label for="{{ $id }}">{{ $label }}</label>
    <select class="form-control select2" name="{{ $name }}" id="{{ $id }}"
        @if (isset($required) && $required) required @endif @if (isset($disabled) && $disabled) disabled @endif>
        <option disabled {{ old($name, isset($value) ? $value : '') == '' ? 'selected' : '' }} selected>
            {{ __('admin.select_' . $name) }}</option>
        @foreach ($options as $option)
            <option value="{{ $option->{$valueKey} }}"
                {{ old($name, isset($value) ? $value : '') == $option->{$valueKey} ? 'selected' : '' }}
                @if (isset($value) && $option->{$valueKey} == $value) selected @endif>
                {{ $option->{$nameKey} }}
            </option>
        @endforeach
    </select>
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
