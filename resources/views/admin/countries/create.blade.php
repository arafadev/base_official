@extends('admin.master')

@section('title', __('admin.create_country'))

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="h5 page-title">{{ __('admin.create_country') }}</h2>

                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('admin.countries.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <x-input id="name_{{ $localeCode }}" name="name[{{ $localeCode }}]"
                                                label="{{ __('admin.name') }} ({{ $properties['name'] }})"
                                                placeholder="{{ __('admin.enter_name') }} ({{ $properties['name'] }})"
                                                :required="false" />
                                        </div>
                                    </div>
                                @endforeach
                                <div class="col-md-6">
                                    <x-input id="country_code" name="country_code" label="{{ __('admin.country_code') }}"
                                        placeholder="{{ __('admin.enter_country_code') }}" :required="true" />

                                </div>

                                <div class="col-md-6">
                                    <x-input id="iso2" name="iso2" label="{{ __('admin.iso2') }}"
                                        placeholder="{{ __('admin.enter_iso2') }}" :required="true" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <x-input id="iso3" name="iso3" label="{{ __('admin.iso3') }}"
                                        placeholder="{{ __('admin.enter_iso3') }}" :required="true" />
                                </div>
                                <div class="col-md-6">
                                    <x-file id="image" name="image" label="{{ __('admin.enter_image') }}"
                                        :required="true" />
                                </div>

                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <button type="submit" class="btn btn-primary mx-2">{{ __('admin.submit') }}</button>
                                <button type="button" class="btn btn-secondary mx-2" onclick="window.history.back();">
                                    {{ __('admin.back') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
@endsection
