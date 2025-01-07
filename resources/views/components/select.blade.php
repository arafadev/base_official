<div class="form-group mb-3">
    <label for="{{ $id }}">{{ $label }}</label>
    <select class="form-control select2" name="{{ $name }}" id="{{ $id }}"
        @if ($required) required @endif>
        <option  disabled selected>{{ __('admin.select_' . $name) }}</option>
        @foreach ($options as $option)
            <option value="{{ $option->{$valueKey} }}" @if (isset($value) && $option->{$valueKey} == $value) selected @endif>
                {{ $option->{$nameKey} }}
            </option>
        @endforeach
    </select>
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
