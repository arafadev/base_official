<div class="form-group mb-3">
    <label for="{{ $id }}">{{ $label }}</label>

    @if (isset($type) && $type === 'checkbox')
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input {{ $class ?? '' }}" id="{{ $id }}"
                name="{{ $name }}" @if (old($name, $value ?? '') == 1) checked @endif
                @if (isset($required) && $required) required @endif @if (isset($disabled) && $disabled) disabled @endif>
            <label class="custom-control-label" for="{{ $id }}">{{ $label }}</label>
        </div>
    @elseif (isset($type) && $type === 'radio')
        <div class="custom-control custom-radio">
            <input type="radio" id="{{ $id }}" name="{{ $name }}"
                class="custom-control-input {{ $class ?? '' }}" value="{{ $value ?? '' }}"
                @if (old($name, $value ?? '') == $value) checked @endif @if (isset($required) && $required) required @endif
                @if (isset($disabled) && $disabled) disabled @endif>
            <label class="custom-control-label" for="{{ $id }}">{{ $label }}</label>
        </div>
    @elseif (isset($type) && $type === 'email')
        <input type="email" id="{{ $id }}" name="{{ $name }}" class="form-control"
            placeholder="{{ $placeholder }}" value="{{ old($name, $value ?? '') }}"
            @if (isset($required) && $required) required @endif @if (isset($disabled) && $disabled) disabled @endif>
    @elseif (isset($type) && $type === 'password')
        <input type="password" id="{{ $id }}" name="{{ $name }}" class="form-control"
            placeholder="{{ $placeholder }}" @if (isset($required) && $required) required @endif
            @if (isset($disabled) && $disabled) disabled @endif>
    @else
        <input type="text" id="{{ $id }}" name="{{ $name }}" class="form-control"
            placeholder="{{ $placeholder }}" value="{{ old($name, $value ?? '') }}"
            @if (isset($required) && $required) required @endif @if (isset($disabled) && $disabled) disabled @endif>
    @endif

    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        @error("name.{$localeCode}")
            <div class="text-danger">
                @if (LaravelLocalization::getCurrentLocale() == $localeCode)
                    @if ($localeCode == 'en')
                        {{ __('The :attribute field is required.', ['attribute' => $label]) }}
                    @elseif ($localeCode == 'ar')
                        {{ __('حقل :attribute مطلوب.', ['attribute' => $label]) }}
                    @endif
                @endif
            </div>
        @enderror
    @endforeach
</div>
