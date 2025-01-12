@extends('admin.master')

@section('title', __('admin.edit_country'))

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="h5 page-title">{{ __('admin.edit_country') }}</h2>

                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('admin.countries.update', $country->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                @foreach (langsWithLabels() as $localeCode => $localeName)
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="name_{{ $localeCode }}">
                                                {{ __('admin.name') }} ({{ $localeName }})
                                            </label>
                                            <input type="text" id="name_{{ $localeCode }}"
                                                name="name[{{ $localeCode }}]" class="form-control"
                                                value="{{ old('name.' . $localeCode, $country->getAllTranslations()[$localeCode] ?? '') }}"
                                                placeholder="{{ __('admin.enter_name') }} ({{ $localeName }})" required>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="country_code">{{ __('admin.country_code') }}</label>
                                        <input type="text" id="country_code" name="country_code"
                                            value="{{ $country->country_code }}" class="form-control" max="3"
                                            placeholder="{{ __('admin.enter_country_code') }}" required>
                                        @error('country_code')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="iso2">{{ __('admin.iso2') }}</label>
                                        <input required type="text" id="iso2" name="iso2"
                                            value="{{ $country->iso2 }}" min="2" max="2" class="form-control"
                                            placeholder="{{ __('admin.enter_iso2') }}">
                                        @error('iso2')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="iso3">{{ __('admin.iso3') }}</label>
                                        <input required type="text" id="iso3" name="iso3"
                                            value="{{ $country->iso3 }}" class="form-control"
                                            placeholder="{{ __('admin.enter_iso3') }}">
                                        @error('iso3')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <x-file id="image" name="image" label="{{ __('admin.enter_image') }}"
                                        :required="false" :src="$country->image" />
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
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('image-preview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
