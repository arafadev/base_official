@extends('admin.master')

@section('title', $title)


@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">{{ $pageTitle }}</h2><hr>

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
