// Images.js — live preview for the image upload field

export function initImageUpload(field) {          // ← export makes it importable
    const input = field.querySelector('input[type="file"]');
    const preview = field.querySelector('#image-preview');
    const placeholder = field.querySelector('#image-placeholder');

    if (!input || !preview) return;

    input.addEventListener('change', () => {
        const file = input.files[0];
        if (!file) return;

        if (preview.dataset.objectUrl) {
            URL.revokeObjectURL(preview.dataset.objectUrl);
        }

        const url = URL.createObjectURL(file);
        preview.dataset.objectUrl = url;

        preview.src = url;
        preview.classList.remove('hidden');
        preview.classList.add('block');
        placeholder?.classList.add('hidden');
        placeholder?.classList.remove('flex');
    });
}

// export a helper that finds and initialises all upload fields
export function initAllImageUploads() {
    document.querySelectorAll('#image-upload-field, .image-upload-field')
        .forEach(initImageUpload);
}