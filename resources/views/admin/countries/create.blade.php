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
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name">{{ __('admin.country_name') }}</label>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                                            class="form-control" placeholder="{{ __('admin.country_name') }}" required>
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="country_code">{{ __('admin.country_code') }}</label>
                                        <input type="text" id="country_code" name="country_code"
                                            value="{{ old('country_code') }}" class="form-control" max="3"
                                            placeholder="{{ __('admin.enter_country_code') }}" required>
                                        @error('country_code')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="iso2">{{ __('admin.iso2') }}</label>
                                        <input required type="iso2" id="iso2" name="iso2"
                                            value="{{ old('iso2') }}" min="2" max="2" class="form-control"
                                            placeholder="{{ __('admin.enter_iso2') }}">
                                        @error('iso2')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="iso3">{{ __('admin.iso3') }}</label>
                                        <input required type="iso3" id="iso3" name="iso3"
                                            value="{{ old('iso3') }}" class="form-control"
                                            placeholder="{{ __('admin.enter_iso3') }}">
                                        @error('iso3')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="custom-file mb-3">
                                        <input type="file" class="custom-file-input" id="image" name="image"
                                            required onchange="previewImage(event)">
                                        <label class="custom-file-label"
                                            for="image">{{ __('admin.choose_file') }}</label>
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 col-md-12">
                                    <div id="image-preview" class="d-none position-relative"
                                        style="width: 150px; height: 150px;">
                                        <img id="image-preview-img" src="#" alt="Image Preview"
                                            class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute"
                                            style="top: 5px; right: 5px;" onclick="removeImage()">X</button>
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
@section('scripts')
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('image-preview-img');
                output.src = reader.result;
                document.getElementById('image-preview').classList.remove('d-none');
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function removeImage() {
            document.getElementById('bs-validation-upload-file').value = "";
            document.getElementById('image-preview-img').src = "#";
            document.getElementById('image-preview').classList.add('d-none');
        }
    </script>

@endsection
