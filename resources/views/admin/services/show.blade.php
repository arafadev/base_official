@extends('admin.master')

@section('title', __('admin.create_service'))

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="h5 page-title">{{ __('admin.show_service') }}</h2>

                <div class="card shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="title">{{ __('admin.title') }}</label>
                                    <input type="text" id="title" name="title" value="{{ $service->title }}" disabled class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="icon">{{ __('admin.icon') }}</label>
                                    <input type="text" id="icon" name="icon" value="{{ $service->icon }}" disabled class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="description">{{ __('admin.description') }}</label>
                                    <textarea required type="description" id="description" name="description" disabled class="form-control"
                                        placeholder="{{ __('admin.enter_description') }}">{{ $service->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary ">{{ __('admin.back') }}</a>
                        </div>
                    </div>
                </div>
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
@endsection
