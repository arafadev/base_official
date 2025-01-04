@extends('admin.master')

@section('title', $title)


@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">{{ $pageTitle }}</h2>

                <div class="page-title-right">
                    <x-button-link :href="$createRoute" :text="$createText" class="btn-primary" />
                    @if ($showDeleteButton)
                        <x-button-link id="delete-selected" :text="$deleteText" class="btn-danger" style="display: none;"
                            :dataRoute="$dataRoute" />
                    @endif
                </div>

                <div class="row my-4">
                    <div class="col-md-12">
                        <x-card>
                            <x-table-tag :headers="$headers" :items="$items" :actions="$actions" />
                        </x-card>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
            const route = @json($dataRoute);
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
                const route = @json($dataRoute);
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
