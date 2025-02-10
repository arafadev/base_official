<style>
    .nav-notif {
        position: relative;
    }

    .notif-badge {
        position: absolute;
        top: -3px;
        right: -3px;
        background: #ff4b2b;
        color: white;
        font-size: 9px;
        font-weight: normal;
        padding: 2px 5px;
        border-radius: 50%;
        min-width: 16px;
        text-align: center;
        line-height: 1;
    }
</style>
<nav class="topnav navbar navbar-light">
    <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
        <i class="fe fe-menu navbar-toggler-icon"></i>
    </button>

    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link text-muted my-2" href="#" id="modeSwitcher" data-mode="light">
                <i class="fe fe-sun fe-16"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-muted my-2"
                href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale() == 'ar' ? 'en' : 'ar') }}"
                id="langSwitcher">
                @if (LaravelLocalization::getCurrentLocale() == 'ar')
                    <span class="flag-icon flag-icon-us"></span>
                @else
                    <span class="flag-icon flag-icon-sa"></span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-muted my-2" href="./#" data-toggle="modal" data-target=".modal-shortcut">
                <span class="fe fe-grid fe-16"></span>
            </a>
        </li>
        <li class="nav-item nav-notif position-relative">
            <a class="nav-link text-muted my-2 position-relative" href="#" data-toggle="modal" data-target=".modal-notif">
                <span class="fe fe-bell fe-16"></span>
        
                @if(auth('admin')->user()->unreadNotifications()->count() > 0)
                    <span class="notif-badge">
                        {{ auth('admin')->user()->unreadNotifications()->count() }}
                    </span>
                @endif
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink"
                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="avatar avatar-sm mt-2">
                    <img src="{{ auth('admin')->user()->avatar }}" alt="Admin Avatar" class="avatar-img rounded-circle"
                        style="width: 30px; height: 30px; object-fit: cover;">
                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="{{ route('admin.profile') }}">{{ __('admin.profile') }}</a>
                <a class="dropdown-item" href="#">{{ __('admin.settings') }}</a>
                <a class="dropdown-item" href="{{ route('admin.logout') }}"
                    style="color: red;">{{ __('admin.logout') }}</a>
            </div>
        </li>
    </ul>
    @include('admin.partials.notification_modal', ['notifications' => auth('admin')->user()->unreadNotifications()->limit(8)->get()])
</nav>
