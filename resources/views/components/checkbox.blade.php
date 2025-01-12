<!-- resources/views/components/checkbox.blade.php -->

<div class="custom-control custom-checkbox">
    <input type="hidden" name="{{ $name }}" value="0">
    <input type="checkbox" class="custom-control-input {{ $class ?? '' }}" id="{{ $id }}"
        name="{{ $name }}" value="1" @if ($value ?? false) checked @endif
        @if ($required ?? false) required @endif @if (isset($disabled) && $disabled) disabled @endif>
    <label class="custom-control-label" for="{{ $id }}">{{ $label }}</label>
</div>
