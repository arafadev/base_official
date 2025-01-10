@extends('admin.master')

@section('title', __('admin.show_site_settings'))

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="h5 page-title">{{ __('admin.show_site_settings') }}</h2>

                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('admin.site_settings.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <x-input id="name_ar" name="name_ar" label="{{ __('admin.name_ar') }}"
                                            :value="$site_settings['name_ar'] ?? ''" placeholder="{{ __('admin.enter_name_ar') }}"
                                            :required="true" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <x-input id="name_en" name="name_en" label="{{ __('admin.name_en') }}"
                                            :value="$site_settings['name_en'] ?? ''" placeholder="{{ __('admin.enter_name_en') }}"
                                            :required="true" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <x-input id="email" name="email" type="email"
                                            label="{{ __('admin.email') }}" :value="$site_settings['email'] ?? ''"
                                            placeholder="{{ __('admin.enter_email') }}" :required="true" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <x-input id="phone" name="phone" type="text"
                                            label="{{ __('admin.phone') }}" :value="$site_settings['phone'] ?? ''"
                                            placeholder="{{ __('admin.enter_phone') }}" :required="true" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <x-input id="whatsapp" name="whatsapp" type="text"
                                            label="{{ __('admin.whatsapp') }}" :value="$site_settings['whatsapp'] ?? ''"
                                            placeholder="{{ __('admin.enter_whatsapp') }}" :required="true" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <x-input id="address" name="address" label="{{ __('admin.address') }}"
                                            :value="$site_settings['address'] ?? ''" placeholder="{{ __('admin.enter_address') }}"
                                            :required="true" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <x-input id="vat" name="vat" type="text" label="{{ __('admin.vat') }}"
                                            :value="$site_settings['vat'] ?? ''" placeholder="{{ __('admin.enter_vat') }}"
                                            :required="true" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <x-input id="admin_percentage" name="admin_percentage" type="text"
                                            label="{{ __('admin.admin_percentage') }}" :value="$site_settings['admin_percentage'] ?? ''"
                                            placeholder="{{ __('admin.enter_admin_percentage') }}" :required="true" />
                                    </div>
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
