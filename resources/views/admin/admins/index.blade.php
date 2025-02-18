@extends('admin.master')

@section('title', __('admin.admins_page'))

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
                <h2 class="mb-2 page-title">{{ __('admin.admins') }}</h2>
                <hr>

                <div class="page-title-right">
                    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
                        {{ __('admin.create_admin') }}
                    </a>
                    <a id="delete-selected" class="btn btn-danger" style="display: none;"
                        data-route="{{ route('admin.admins.deleteSelected') }}">
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
                                                    {{ __('admin.phone') }}</th>
                                                <th class="text-center" style="color: black; font-weight: 600;">
                                                    {{ __('admin.email') }}</th>
                                                <th class="text-center" style="color: black; font-weight: 600;">
                                                    {{ __('admin.role') }}</th>
                                                <th class="text-center" style="color: black; font-weight: 600;">
                                                    {{ __('admin.is_blocked') }}</th>
                                                <th class="text-center" style="color: black; font-weight: 600;">
                                                    {{ __('admin.is_notify') }}</th>
                                                <th class="text-center" style="color: black; font-weight: 600;">
                                                    {{ __('admin.created_at') }}</th>
                                                <th class="text-center" style="color: black; font-weight: 600;">
                                                    {{ __('admin.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($admins as $admin)
                                                <tr>
                                                    <td class="text-center"> <input type="checkbox" class="select-row"
                                                            value="{{ $admin->id }}"></td>
                                                    <td class="text-center">{{ $admin->id }}</td>
                                                    <td class="text-center">
                                                        <img src="{{ $admin->avatar }}" alt="Image"
                                                            style="width: 50px; height: 50px; object-fit: cover;">
                                                    </td>
                                                    <td class="text-center">{{ $admin->name }}</td>
                                                    <td class="text-center"><a
                                                            href="tel:{{ $admin->full_phone }}">{{ $admin->full_phone }}</a>
                                                    </td>
                                                    <td class="text-center"><a
                                                            href="mail:{{ $admin->email }}">{{ $admin->email }}</a></td>
                                                    <td class="text-center">{{ ucfirst($admin->role?->name) }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.admins.toggle', ['id' => $admin->id, 'field' => 'is_blocked']) }}"
                                                            style="text-decoration: none;">
                                                            @if ($admin->is_blocked)
                                                                <i class="fe fe-slash"
                                                                    style="color: #e74c3c; font-size: 18px;"></i>
                                                            @else
                                                                <i class="fe fe-check"
                                                                    style="color: #2ecc71; font-size: 18px;"></i>
                                                            @endif
                                                        </a>
                                                    </td>

                                                    <td class="text-center">
                                                        <a href="{{ route('admin.admins.toggle', ['id' => $admin->id, 'field' => 'is_notify']) }}"
                                                            style="text-decoration: none;">
                                                            @if ($admin->is_notify)
                                                                <i class="fe fe-bell"
                                                                    style="color: #2ecc71; font-size: 18px;"></i>
                                                            @else
                                                                <i class="fe fe-bell-off"
                                                                    style="color: #e74c3c; font-size: 18px;"></i>
                                                            @endif
                                                        </a>
                                                    </td>

                                                    <td class="text-center">{{ $admin->created_at->diffForHumans() }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.admins.show', $admin->id) }}"
                                                            class="icon-link show">
                                                            <i class="fe fe-eye fe-16"></i>
                                                        </a>
                                                        <a href="{{ route('admin.admins.edit', $admin->id) }}"
                                                            class="icon-link edit">
                                                            <i class="fe fe-edit fe-16"></i>
                                                        </a>
                                                        <a href="#" class="icon-link delete"
                                                            data-id="{{ $admin->id }}"
                                                            data-route="{{ route('admin.admins.delete', $admin->id) }}">
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
