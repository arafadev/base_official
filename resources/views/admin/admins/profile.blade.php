@extends('admin.master')

@section('title', __('admin.edit_admin'))

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="h5 page-title">{{ __('admin.edit_admin') }}</h2>
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('admin.admins.update', auth('admin')->user()->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <x-input id="name" name="name" label="{{ __('admin.name') }}"
                                            placeholder="{{ __('admin.enter_name') }}" :value="auth('admin')->user()->name"
                                            :required="true" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <x-select id="country_code" label="{{ __('admin.country_code') }}" name="country_code"
                                        :options="$countries" valueKey="country_code" :value="auth('admin')->user()->country_code" nameKey="name"
                                        :required="true" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <x-input id="phone" name="phone" :value="auth('admin')->user()->phone" label="{{ __('admin.phone') }}"
                                        placeholder="{{ __('admin.enter_phone') }}" :required="true" />
                                </div>


                                <div class="col-md-6">
                                    <x-input id="email" name="email" :value="auth('admin')->user()->email" label="{{ __('admin.email') }}"
                                        placeholder="{{ __('admin.enter_email') }}" :required="true" type="email" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <x-select id="role_id" label="{{ __('admin.role') }}" name="role_id" :options="$roles"
                                        :value="auth('admin')->user()->role_id" valueKey="id" nameKey="name" :required="true" />
                                </div>


                                <div class="col-md-6">
                                    <x-input type="password" id="password" name="password"
                                        label="{{ __('admin.password') }}" placeholder="{{ __('admin.enter_password') }}"
                                        :required="false" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <x-file id="avatar" name="avatar" label="{{ __('admin.enter_avatar') }}"
                                        :required="false" :src="auth('admin')->user()->avatar" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <x-checkbox id="is_notify" name="is_notify" label="{{ __('admin.is_notify') }}"
                                        :value="auth('admin')->user()->is_notify" /><br>

                                    @if (auth('admin')->user()->id)
                                        <x-checkbox id="is_blocked" name="is_blocked"
                                            label="{{ __('admin.block_account') }}" :value="auth('admin')->user()->is_blocked" />
                                    @endif
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
