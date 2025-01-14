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
