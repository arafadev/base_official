<div class="form-group mb-3">
    <label for="{{ $id }}">{{ $label }}</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="{{ $id }}" name="{{ $name }}"
            @if (isset($required) && $required) required @endif @if (isset($disabled) && $disabled) disabled @endif
            onchange="previewImage('{{ $id }}')">
        <label class="custom-file-label" for="{{ $id }}">
            {{ $label }}
        </label>
    </div>
</div>

<!-- Image preview -->
<div id="{{ $id }}-preview-container" class="position-relative {{ isset($src) && $src ? '' : 'd-none' }}"
    style="width: 150px; height: 150px;">
    <img id="{{ $id }}-preview" src="{{ $src ?? '#' }}" alt="Image Preview" class="rounded-circle"
        style="width: 100%; height: 100%; object-fit: cover;">
    <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 5px; right: 5px;"
        onclick="removeImage('{{ $id }}')">
        &times;
    </button>
</div>
<hr>


@section('scripts')
    <script>
        function previewImage(inputId) {
            var fileInput = document.getElementById(inputId);
            var previewContainer = document.getElementById(inputId + '-preview-container');
            var previewImage = document.getElementById(inputId + '-preview');

            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('d-none');
                };
                reader.readAsDataURL(fileInput.files[0]);
            }
        }

        function removeImage(inputId) {
            var fileInput = document.getElementById(inputId);
            var previewContainer = document.getElementById(inputId + '-preview-container');
            var previewImage = document.getElementById(inputId + '-preview');

            fileInput.value = '';
            previewImage.src = '#';
            previewContainer.classList.add('d-none');
        }
    </script>
@endsection
