@extends('admin.master')

@section('title', __('admin.edit_service'))

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="h5 page-title">{{ __('admin.edit_service') }}</h2>

                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('admin.services.update', $service->id) }}') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="title">{{ __('admin.title') }}</label>
                                        <input type="text" id="title" name="title" value="{{ $service->title }}"
                                            class="form-control" placeholder="{{ __('admin.enter_title') }}" required>
                                        @error('title')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="icon">{{ __('admin.icon') }}</label>
                                        <input type="text" id="icon" name="icon" value="{{ $service->icon }}"
                                            class="form-control" placeholder="{{ __('admin.enter_icon') }}" required>
                                        @error('icon')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="description">{{ __('admin.description') }}</label>
                                        <textarea required type="description" id="description" name="description" class="form-control"
                                            placeholder="{{ __('admin.enter_description') }}"> {{ $service->description }}</textarea>
                                        @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">{{ __('admin.submit') }}</button>
                                <button type="submit" class="btn btn-secondary   ">{{ __('admin.back') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
@endsection
