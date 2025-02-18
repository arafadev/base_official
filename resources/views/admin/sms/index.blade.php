@extends('admin.master')
@section('title', __('admin.sms_packages'))

@section('content')
    <div class="row">

        @foreach ($smss as $sms)
            <div class="col-12 col-md-6">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-center">
                        <div class="form-check form-check-success">
                            <input class="form-check-input change-sms" name="id" type="radio" id="{{ $sms->id }}"
                                {{ $sms->active == 1 ? 'checked' : '' }} />
                            <label class="form-check-label" for="{{ $sms->id }}">{{ $sms->name }}</label>
                        </div>
                    </div>
                    <div class="one-sms d-flex justify-content-center align-items-baseline mb-1 ">

                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.sms.update', ['id' => $sms->id]) }}"
                            class="update form-horizontal needs-validation" novalidate>
                            @csrf
                            <div class="row sms">
                                <div class="col-12">
                                    <x-input id="sender_name" name="sender_name" :value="$sms->sender_name"
                                        label="{{ __('admin.sender_name') }}"
                                        placeholder="{{ __('admin.enter_sender_name') }}" :required="true"
                                        type="text" />
                                </div>
                                <div class="col-12">
                                    <x-input id="user_name" name="user_name" :value="$sms->user_name"
                                        label="{{ __('admin.user_name') }}" placeholder="{{ __('admin.enter_user_name') }}"
                                        :required="true" type="text" />
                                </div>
                                <div class="col-12">

                                    <x-input id="password" name="password" :value="$sms->password"
                                        label="{{ __('admin.password') }}" placeholder="{{ __('admin.enter_password') }}"
                                        :required="true" type="text" />

                                </div>
                                <div class="col-12 d-flex justify-content-center mb-2">
                                    <button type="submit"
                                        class="submit_button btn rounded-pill btn-primary m-2">{{ __('admin.update') }}</button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

{{-- <x-admin.config sweetAlert2 validation /> --}}

@section('scripts')
    <script>
        $(document).ready(function() {

            $(document).on('click', '.change-sms', function(e) {
                let formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('admin.sms.change') }}',
                    method: 'post',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: this.id
                    },
                    dataType: 'json',
                    success: (response) => {
                        toastr.success(
                            '{{ __('admin.the_package_has_been_successfully_activated') }}'
                        )
                    },
                });
            });

            $(document).on('submit', '.update', function(e) {
                e.preventDefault();
                var url = $(this).attr('action')
                $.ajax({
                    url: url,
                    method: 'post',
                    data: new FormData($(this)[0]),
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: () => {
                        $(this).find(".submit_button").html(
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                        ).attr('disable', true)
                    },
                    success: (response) => {
                        $(this).find(".submit_button").html("{{__('admin.modernization')}}").attr('disable',false)
                        toastr.success(
                            '{{ __('admin.packge_changed_successfully') }}'
                        )
                    },
                    error: (xhr) => {
                        $(".text-danger").remove()
                        $('.store input').removeClass('border-danger')
                        $(this).find(".submit_button").html("{{ __('admin.modernization') }}")
                            .attr('disable', false)
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            toastr.error(value)
                        });
                    },
                });

            });
        });
    </script>
@endsection
