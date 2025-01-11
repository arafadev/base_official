@extends('admin.master')

@section('title', __('admin.create_role'))

@section('css')
    <style>
        .permission-group {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .group-name {
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .permissions-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .permissions-list .custom-control {
            flex: 0 0 25%;
        }

        .select-all-section {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .select-all-section input[type="checkbox"] {
            margin: 0;
        }

        .select-all-section label {
            margin: 0;
            padding-left: 5px;
            font-weight: bold;
            color: #007bff;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
            line-height: 1.5;
        }


        .select-all-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .select-all-group input[type="checkbox"] {
            margin: 0;
        }

        .select-all-group label {
            margin: 0;
        }
    </style>
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="h5 page-title">{{ __('admin.create_role') }}</h2>

                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('admin.role.roles_has_permission.store') }}" method="post" >
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-md-6">
                                        <x-select id="role_id" label="{{ __('admin.roles') }}" name="role_id"
                                            :options="$roles" valueKey="id" nameKey="name" :required="true" />
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="permissions-container">
                                <div class="global-select-all mb-4">
                                    <input type="checkbox" id="global_select_all" name="global_select_all" value="1" />
                                    <label for="global_select_all">{{ __('admin.select_all') }}</label>
                                </div>


                                @foreach ($permissions as $groupName => $groupPermissions)
                                    <div class="permission-group mb-4 ">
                                        <h5 class="group-name">{{ ucfirst($groupName) }}</h5>

                                        <!-- "Select All" for each group -->
                                        <div class="select-all-section custom-control custom-checkbox">
                                            <input type="hidden" name="select_all_{{ $groupName }}" value="0">
                                            <input type="checkbox"
                                                class="custom-control-input select-all-group permission-checkbox"
                                                id="select_all_{{ $groupName }}" data-group="{{ $groupName }}">
                                            <label class="custom-control-label "
                                                for="select_all_{{ $groupName }}">{{ __('admin.select_all') }}
                                                {{ ucfirst($groupName) }}</label>
                                        </div>

                                        <div class="permissions-list d-flex flex-wrap">
                                            @foreach ($groupPermissions as $permission)
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input permission-checkbox"
                                                    id="permission_{{ $permission->id }}" name="permissions[]"
                                                    value="{{ $permission->id }}" 
                                                    @if (old('permissions') && in_array($permission->id, old('permissions'))) checked @endif
                                                    data-group="{{ $groupName }}" />
                                                <label class="custom-control-label"
                                                    for="permission_{{ $permission->id }}">
                                                    {{ ucfirst(str_replace('.', ' ', $permission->name)) }}
                                                </label>
                                            </div>
                                        @endforeach
                                        
                                        </div>
                                    </div>
                                @endforeach
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
        document.addEventListener('DOMContentLoaded', () => {
            // Reset all checkboxes to unchecked on page load
            document.querySelectorAll('.permission-checkbox, .global-select-all')
                .forEach(checkbox => {
                    checkbox.checked = false;
                });

            // Handle global "Select All" functionality
            const globalSelectAll = document.getElementById('global_select_all');
            globalSelectAll.addEventListener('change', function() {
                const allPermissions = document.querySelectorAll('.permission-checkbox');
                allPermissions.forEach(checkbox => checkbox.checked = this.checked);
            });

            // Handle "Select All" for each group
            document.querySelectorAll('.select-all-group').forEach(groupCheckbox => {
                groupCheckbox.addEventListener('change', function() {
                    const group = this.getAttribute('data-group');
                    const groupPermissions = document.querySelectorAll(
                        `.permission-checkbox[data-group="${group}"]`);
                    groupPermissions.forEach(checkbox => checkbox.checked = this.checked);
                });
            });

            // Handle individual permission checkbox behavior
            document.querySelectorAll('.permission-checkbox').forEach(permissionCheckbox => {
                permissionCheckbox.addEventListener('change', function() {
                    updateGlobalSelectAll();
                });
            });

            // Function to update the global "Select All" checkbox
            function updateGlobalSelectAll() {
                const allPermissions = document.querySelectorAll('.permission-checkbox');
                const allChecked = Array.from(allPermissions).every(checkbox => checkbox.checked);
                globalSelectAll.checked = allChecked;
            }
        });
    </script>
@endsection
