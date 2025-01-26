@extends('admin.auth.master')

@section('content')
<div class="wrapper vh-100 d-flex justify-content-center align-items-center" 
    style="background-image: url('{{ LaravelLocalization::getCurrentLocale() == 'ar' ? asset('defaults/sau.jpg') : asset('defaults/usa.jpg') }}'); background-size: cover; background-position: center;">
    <div class="col-lg-4 col-md-6 col-10 bg-white p-5 rounded shadow-sm">
        <div class="text-center mb-4">
            <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale() == 'ar' ? 'en' : 'ar') }}" id="langSwitcher" class="d-inline-block">
                @if (LaravelLocalization::getCurrentLocale() == 'ar')
                    <span class="flag-icon flag-icon-us" style="font-size: 2em;"></span>
                @else
                    <span class="flag-icon flag-icon-sa" style="font-size: 2em;"></span>
                @endif
            </a>
        </div>
        <div class="text-center mb-4">
            <h1 class="h3 font-weight-bold text-primary">{{ __('keywords.login') }}</h1>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger text-center">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email" class="font-weight-bold">{{ __('keywords.email') }}</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg border-secondary" placeholder="{{ __('keywords.email') }}" required>
            </div>
            <div class="form-group mt-3">
                <label for="password" class="font-weight-bold">{{ __('keywords.password') }}</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control form-control-lg border-secondary" placeholder="{{ __('keywords.password') }}" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary toggle-password">
                            <i class="feather-icon icon-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block mt-4">{{ __('keywords.login') }}</button>
        </form>
        <p class="text-center mt-4 text-muted small">
            {{ __('keywords.copyright', ['year' => date('Y')]) }}
        </p>
    </div>
</div>

<script>
    // Toggle Password Visibility
    document.querySelector('.toggle-password').addEventListener('click', function () {
        const passwordField = document.getElementById('password');
        const icon = this.querySelector('i');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.replace('icon-eye', 'icon-eye-off');
        } else {
            passwordField.type = 'password';
            icon.classList.replace('icon-eye-off', 'icon-eye');
        }
    });
</script>
@endsection
