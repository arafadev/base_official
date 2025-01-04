<!-- resources/views/components/icon-link.blade.php -->
@props(['href', 'class', 'dataId' => '', 'icon', 'dataRoute' => ''])

<a href="{{ $href }}" class="icon-link {{ $class }}" data-id="{{ $dataId }}" data-route="{{ $dataRoute }}">
    <i class="{{ $icon }} fe-16"></i>
</a>
