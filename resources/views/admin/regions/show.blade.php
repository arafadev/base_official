@extends('admin.master')

@section('title', __('admin.create_region'))

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="h5 page-title">{{ __('admin.create_region') }}</h2>

                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('admin.regions.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <x-input id="name" name="name" label="{{ __('admin.name') }}" :value="$region->name"
                                            placeholder="{{ __('admin.enter_name') }}" :required="true" />
                                    </div>
                                    <div class="col-md-6">
                                        <x-select id="country_id" label="{{ __('admin.country') }}" name="country_id"
                                        :options="$countries" valueKey="country_id" :value="$region->country_id" nameKey="name"
                                        :disabled="true" />
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
