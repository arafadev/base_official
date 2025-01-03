    @extends('admin.master')

    @section('title', __('admin.services_page'))

    <style>
        .icon-link {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            color: inherit;
            margin-right: 10px;
            padding: 5px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .icon-link i {
            font-size: 1.2em;
            margin-right: 5px;
        }

        .icon-link:hover {
            background-color: #f0f0f0;
            color: #007bff;
            text-decoration: none;
        }

        .icon-link.show i {
            color: #28a745;
        }

        .icon-link.delete i {
            color: #dc3545;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            outline: 0;
        }

        .modal-dialog {
            position: relative;
            width: auto;
            margin: 10px;
            pointer-events: none;
        }

        .modal-content {
            position: relative;
            display: flex;
            flex-direction: column;
            width: 100%;
            pointer-events: auto;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 0.3rem;
            outline: 0;
        }

        .modal-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
            border-top-left-radius: 0.3rem;
            border-top-right-radius: 0.3rem;
        }

        .modal-title {
            margin-bottom: 0;
            line-height: 1.5;
        }

        .close {
            padding: 1rem;
            margin: -1rem -1rem -1rem auto;
        }

        .modal-body {
            position: relative;
            flex: 1 1 auto;
            padding: 1rem;
        }

        .modal-body p {
            color: #000;
            font-weight: bold;
        }

        .modal-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 1rem;
            border-top: 1px solid #dee2e6;
        }
    </style>

    @section('content')
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h2 class="mb-2 page-title">{{ __('admin.services_page') }}</h2>
                    <hr>
                    <div class="page-title-right">
                        <a href="{{ route('admin.services.create') }}" class="btn btn-sm btn-primary">
                            {{ __('admin.create_service') }}
                        </a>
                        <button id="delete-selected" class="btn btn-sm btn-danger" style="display: none;">
                            {{ __('admin.delete_selected') }}
                        </button>
                    </div>
                    <div class="row my-4">
                        <!-- Small table -->
                        <div class="col-md-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <!-- table -->
                                    <table class="table datatables" id="dataTable-1">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="select-all"></th>
                                                <th>#</th>
                                                <th style="color:black"><b>{{ __('admin.title') }}</b></th>
                                                <th style="color:black"><b>{{ __('admin.description') }}</b></th>
                                                <th style="color:black"><b>{{ __('admin.icon') }}</b></th>
                                                <th style="color:black"><b>{{ __('admin.actions') }}</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($services as $service)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="select-row"
                                                            value="{{ $service->id }}">
                                                    </td>
                                                    <td>{{ $service->id }}</td>
                                                    <td>{{ $service->title }}</td>
                                                    <td>{{ Str::limit($service->description, 15) }}</td>
                                                    <td>{{ $service->icon }}</td>
                                                    <td>
                                                        <x-action-link
                                                            href="{{ route('admin.services.show', $service->id) }}"
                                                            class="show" />
                                                        <x-action-link
                                                            href="{{ route('admin.services.edit', $service->id) }}"
                                                            class="edit" />
                                                        <x-action-link href="#" class="delete"
                                                            data-id="{{ $service->id }}" />
                                                    </td>

                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">
                                                        {{ __('admin.no_services_found') }}
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- simple table -->
                    </div> <!-- end section -->
                </div> <!-- .col-12 -->
            </div> <!-- .row -->
        </div> <!-- .container-fluid -->

        <!-- Confirmation Modal -->
        <div class="modal" id="confirmation-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('admin.confirmation') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="confirmation-message">{{ __('admin.are_you_sure_deleteing_selected_elements') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button id="confirm-delete" class="btn btn-danger">{{ __('admin.delete') }}</button>
                        <button id="cancel-delete" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('admin.cancel') }}</button>
                    </div>
                </div>
            </div>
        </div>

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
                if (selectedIds.length > 1) {
                    showConfirmationModal(() => {
                        deleteItems(selectedIds);
                    });
                }
            });

            document.querySelectorAll('.icon-link.delete').forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const id = this.getAttribute('data-id');
                    showConfirmationModal(() => {
                        deleteItems([id]);
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

            function deleteItems(ids) {
                fetch('{{ route('admin.services.deleteSelected') }}', {
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
