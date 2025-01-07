@extends('admin.master')

@section('title', __('admin.edit_service'))

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="h5 page-title">{{ __('admin.edit_service') }}</h2>

                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('admin.services.update', $service->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <x-input id="title" name="title" label="{{ __('admin.title') }}"
                                        placeholder="{{ __('admin.enter_title') }}" :value="$service->title" :required="true" />
                                </div>
                                <div class="col-md-6">
                                    <x-input id="icon" name="icon" label="{{ __('admin.icon') }}"
                                        placeholder="{{ __('admin.enter_icon') }}" :value="$service->icon" :required="true" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <x-textarea id="description" name="description" label="{{ __('admin.description') }}"
                                        placeholder="{{ __('admin.enter_description') }}" :value="$service->description"
                                        :required="true" />
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">{{ __('admin.submit') }}</button>
                                <a href="{{ route('admin.services.index') }}"
                                    class="btn btn-secondary">{{ __('admin.back') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
@endsection
