<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ route('admin.dashboard') }}">
                <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120"
                    xml:space="preserve">
                    <g>
                        <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                        <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                        <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                    </g>
                </svg>
            </a>
        </div>

        <!-- Sections Rendering -->
        @php
            $crudRegistry = config('crud_registry');
        @endphp

        <ul class="navbar-nav flex-fill w-100 mb-2">

            <x-sidebar-tab href="" icon="fe fe-home"
                name="{{ __('admin.home') }}"></x-sidebar-tab>

            @foreach ($crudRegistry as $section)
                @if (
                    !empty($section['base_permission']) &&
                        auth('admin')->user()->can($section['base_permission'] . '.index'))
                    @if ($section['is_dropdown'])
                        <li class="nav-item dropdown">
                            @can($section['base_permission'] . '.index')
                                <a href="#dropdown-{{ $section['base_permission'] }}" data-toggle="collapse"
                                    aria-expanded="false" class="dropdown-toggle nav-link">
                                    <i class="{{ $section['icon'] }}"></i>
                                    <span
                                        class="ml-3 item-text">{{ __('admin' . '.' . $section['translation_key']) }}</span>
                                </a>
                                <ul class="collapse list-unstyled pl-4 w-100"
                                    id="dropdown-{{ $section['base_permission'] }}">
                                    @foreach ($section['children'] as $child)
                                        @if (!empty($child['route']))
                                            <li class="nav-item">
                                                <a class="nav-link pl-3" href="{{ route($child['route']) }}">
                                                    <span
                                                        class="ml-1 item-text">{{ __('admin.' . $child['translation_key']) }}</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endcan
                        </li>
                    @else
                        @can($section['base_permission'] . '.index')
                            <x-sidebar-tab href="{{ route($section['route']) }}" icon="{{ $section['icon'] }}"
                                name="{{ __('admin' . '.' . $section['translation_key']) }}"></x-sidebar-tab>
                        @endcan
                    @endif
                @endif
            @endforeach
        </ul>
    </nav>
</aside>
