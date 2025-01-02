<!DOCTYPE html>
<html lang="en">

@include('site.partials.head')

<body>
    <div class="container-xxl bg-white p-0">
        @include('site.partials.spinner')

        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
            @include('site.partials.navbar')

            @yield('hero')
        </div>
        <!-- Navbar & Hero End -->

        @yield('content')

        @include('site.partials.footer')

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    @include('site.partials.scripts')
</body>

</html>
