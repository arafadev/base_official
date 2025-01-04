<!-- resources/views/components/button.blade.php -->
@props(['type' => 'button', 'class' => 'btn-primary', 'id' => '', 'style' => '', 'disabled' => false])

<button type="{{ $type }}" id="{{ $id }}" class="btn {{ $class }}" style="{{ $style }}" {{ $disabled ? 'disabled' : '' }}>
    {{ $slot }}
</button>