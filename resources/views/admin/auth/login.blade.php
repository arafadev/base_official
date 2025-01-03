@extends('admin.auth.master')

@section('content')
    <div class="wrapper vh-100">

        <div class="row align-items-center h-100">

            <form class="col-lg-3 col-md-4 col-10 mx-auto text-center" action="{{ route('admin.login') }}" method="POST">
                <div class="mb-3">
                    <a class="nav-link text-muted my-2"
                        href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale() == 'ar' ? 'en' : 'ar') }}"
                        id="langSwitcher" style="font-size: 2em;">
                        @if (LaravelLocalization::getCurrentLocale() == 'ar')
                            <span class="flag-icon flag-icon-us"></span>
                        @else
                            <span class="flag-icon flag-icon-sa"></span>
                        @endif
                    </a>
                </div>
                @csrf
                <h1 class="h4 mb-3">{{ __('keywords.login') }}</h1>

                @if ($errors->any())
                    <div class="alert alert-danger text-center"
                        style="font-size: 1.2em; font-weight: bold; margin: 0 auto 10px auto; max-width: 500px;">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="form-group">
                    <label for="inputEmail" class="sr-only">{{ __('keywords.email') }}</label>
                    <input type="email" id="inputEmail" name="email" value="{{ old('email') }}"
                        class="form-control form-control-lg" placeholder="{{ __('keywords.email') }} " >
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="sr-only">{{ __('keywords.password') }} </label>
                    <input type="password" id="inputPassword" name="password" class="form-control form-control-lg"
                        placeholder="{{ __('keywords.password') }}" >
                </div>
                {{-- <div class="checkbox mb-3">
                    <label>
                        <input type="checkbox" value="remember-me"> Stay logged in </label>
                </div> --}}
                <button class="btn btn-lg btn-primary btn-block" type="submit">{{ __('keywords.login') }}</button>
                <p class="mt-5 mb-3 text-muted">{{ __('keywords.copyright', ['year' => date('Y')]) }}</p>
            </form>
        </div>
    </div>
@endsection
