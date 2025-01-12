@extends('admin.master')

@section('title', __('admin.edit_region'))

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="h5 page-title">{{ __('admin.edit_region') }}</h2>

                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('admin.regions.update', $region->id) }}" method="post"
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
                                                value="{{ old('name.' . $localeCode, $region->getAllTranslations()[$localeCode] ?? '') }}"
                                                placeholder="{{ __('admin.enter_name') }} ({{ $localeName }})" required>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="col-md-6">
                                    <x-select id="country_id" label="{{ __('admin.country') }}" name="country_id"
                                        :options="$countries" valueKey="id" :value="$region->country_id" nameKey="name"
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
