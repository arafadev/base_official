@extends('admin.master')

@section('title', __('admin.countries_page'))

<style>
    td.text-center .icon-link {
        display: inline-flex;
        align-items: center;
        margin: 0 5px;
    }

    td.text-center {
        white-space: nowrap;
    }

    .icon-link i {
        font-size: 18px;
        margin-right: 5px;
    }
</style>

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">{{ __('admin.countries') }}</h2>
                <hr>

                <div class="page-title-right">
                    <a href="{{ route('admin.countries.create') }}" class="btn btn-primary">
                        {{ __('admin.create_admin') }}
                    </a>
                    <a id="delete-selected" class="btn btn-danger" style="display: none;"
                        data-route="{{ route('admin.countries.deleteSelected') }}">
                        {{ __('admin.delete_selected') }}
                    </a>
                </div>

                <div class="row my-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-container">
                                    <table class="table datatables" id="dataTable-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center"><input type="checkbox" id="select-all"></th>
                                                <th class="text-center">#</th>
                                                <th class="text-center" style="color: black; font-weight: 600;">
                                                    {{ __('admin.image') }}</th>
                                                <th class="text-center" style="color: black; font-weight: 600;">
                                                    {{ __('admin.name') }}</th>
                                                <th class="text-center" style="color: black; font-weight: 600;">
                                                    {{ __('admin.country_code') }}</th>
                                                <th class="text-center" style="color: black; font-weight: 600;">
                                                    {{ __('admin.iso2') }}</th>
                                                <th class="text-center" style="color: black; font-weight: 600;">
                                                    {{ __('admin.iso3') }}</th>
                                                <th class="text-center" style="color: black; font-weight: 600;">
                                                    {{ __('admin.created_at') }}</th>
                                                <th class="text-center" style="color: black; font-weight: 600;">
                                                    {{ __('admin.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($countries as $country)
                                                <tr>
                                                    <td class="text-center"> <input type="checkbox" class="select-row"
                                                            value="{{ $country->id }}"></td>
                                                    <td class="text-center">{{ $country->id }}</td>
                                                    <td class="text-center">
                                                        <img src="{{ $country->avatar }}" alt="Image"
                                                            style="width: 50px; height: 50px; object-fit: cover;">
                                                    </td>
                                                    <td class="text-center">{{ $country->name }}</td>
                                                    <td class="text-center">{{ $country->country_code }}</td>
                                                    <td class="text-center">{{ $country->iso2 }}</td>
                                                    <td class="text-center">{{ $country->iso3 }}</td>

                                                    <td class="text-center">{{ $country->created_at->diffForHumans() }}</td>

                                                    {{-- Actions --}}
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.countries.show', $country->id) }}"
                                                            class="icon-link show">
                                                            <i class="fe fe-eye fe-16"></i>
                                                        </a>
                                                        <a href="{{ route('admin.countries.edit', $country->id) }}"
                                                            class="icon-link edit">
                                                            <i class="fe fe-edit fe-16"></i>
                                                        </a>
                                                        <a href="#" class="icon-link delete"
                                                            data-id="{{ $country->id }}"
                                                            data-route="{{ route('admin.countries.delete', $country->id) }}">
                                                            <i class="fe fe-trash fe-16"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="11" class="text-center">
                                                        {{ __('admin.no_items_found') }}
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.confirmation-modal')
@endsection

@section('scripts')
    <script>
        document.getElementById('select-all').addEventListener('click', function(event) {
            const checkboxes = document.querySelectorAll('.select-row');
            checkboxes.forEach(checkbox => {
                checkbox.checked = event.target.checked;
            });
            toggleDeleteButton();
        });

        document.querySelectorAll('.select-row').forEach(checkbox => {
            checkbox.addEventListener('change', toggleDeleteButton);
        });

        function toggleDeleteButton() {
            const selected = document.querySelectorAll('.select-row:checked').length > 1;
            document.getElementById('delete-selected').style.display = selected ? 'inline-block' : 'none';
        }

        document.getElementById('delete-selected').addEventListener('click', function() {
            const selectedIds = Array.from(document.querySelectorAll('.select-row:checked')).map(checkbox =>
                checkbox.value);
            const route = @json(route('admin.admins.deleteSelected'));
            if (selectedIds.length > 1) {
                showConfirmationModal(() => {
                    deleteItems(selectedIds, route);
                });
            }
        });

        document.querySelectorAll('.icon-link.delete').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const id = this.getAttribute('data-id');
                const route = @json(route('admin.admins.deleteSelected'));
                showConfirmationModal(() => {
                    deleteItems([id], route);
                });
            });
        });

        function showConfirmationModal(onConfirm) {
            const modal = document.getElementById('confirmation-modal');
            modal.style.display = 'block';

            document.getElementById('confirm-delete').onclick = function() {
                modal.style.display = 'none';
                onConfirm();
            };

            document.getElementById('cancel-delete').onclick = function() {
                modal.style.display = 'none';
            };

            document.querySelector('.close').onclick = function() {
                modal.style.display = 'none';
            };
        }

        function deleteItems(ids, route) {
            fetch(route, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        ids
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        ids.forEach(id => {
                            document.querySelector(`input[value="${id}"]`).closest('tr').remove();
                        });
                        toastr.success(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
