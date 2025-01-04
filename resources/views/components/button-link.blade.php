<!-- resources/views/components/button-link.blade.php -->
@props(['href' => '#', 'text', 'class' => 'btn-primary', 'id' => '', 'style' => '', 'visible' => true, 'dataRoute' => ''])

@if($visible)
    <a href="{{ $href }}" id="{{ $id }}" class="btn {{ $class }}" style="{{ $style }}" data-route="{{ $dataRoute }}">
        {{ $text }}
    </a>
@endif