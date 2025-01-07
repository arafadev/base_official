    <div class="form-group mb-3">
        <label for="{{ $id }}">{{ $label }}</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input " id="{{ $id }}" name="{{ $name }}"
                @if ($required) required @endif onchange="previewImage(event)">
            <label class="custom-file-label" for="{{ $id }}">
                {{ $label }}
            </label>
        </div>
    </div>


    <!-- Image preview -->
    <div id="image-preview" class="position-relative"
        style="width: 150px; height: 150px; @if (empty($src)) display: none; @endif">
        <img id="image-preview-img" src="{{ $src ?? '#' }}" alt="Image Preview" class="rounded-circle"
            style="width: 100%; height: 100%; object-fit: cover;">
        <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 5px; right: 5px;"
            onclick="removeImage()">X</button>
    </div>
