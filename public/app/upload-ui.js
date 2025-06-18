document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.custom-upload').forEach(uploadBox => {
        const fileInput = uploadBox.querySelector('input[type="file"]');
        const uploadText = uploadBox.querySelector('.upload-text');

        // Handle drag & drop
        uploadBox.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadBox.classList.add('dragover');
        });

        uploadBox.addEventListener('dragleave', () => {
            uploadBox.classList.remove('dragover');
        });

        uploadBox.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadBox.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                uploadText.textContent = files[0].name;
            }
        });

        // Handle manual selection via click
        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) {
                uploadText.textContent = fileInput.files[0].name;
            }
        });
    });
});
