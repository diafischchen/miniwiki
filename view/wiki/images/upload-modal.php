<div class="modal" id="uploadModal">
    <div class="modal-box">
        <div class="modal-header">
            Upload Images
            <button class="modal-close-button font-lg modal-closer"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-content">
            <div class="dropzone" id="dropzone">
                <div class="dropzone-icon">
                    <i class="fa-regular fa-image"></i>
                </div>
                <div class="dropzone-content">
                    Drag & Drop or browse for files
                </div>
                <input type="file" class="dropzone-input" id="dropzone-input" multiple />
            </div>

            <div class="dropzone-previews" id="dropzone-previews"></div>

        </div>
        <div class="modal-footer">
            <div class="modal-footer-buttons">
                <div class="button modal-footer-button modal-closer">Cancel</div>
                <div class="button modal-footer-button">Upload</div>
            </div>
        </div>
    </div>
</div>


<script>

// Get DOM elements for the dropzone functionality
const dropzone = document.getElementById('dropzone')
const fileInput = document.getElementById('dropzone-input')

/**
 * Handle file input change event (when user selects files via browse button)
 */
fileInput.addEventListener('change', (e) => {
    const files = e.target.files;
    handleFiles(files);
})

/**
 * Handle dropzone click event to trigger file selection dialog
 */
dropzone.addEventListener('click', (e) => {
    fileInput.click()
})

/**
 * Handle drag enter event to prevent default browser behavior
 */
dropzone.addEventListener('dragenter', (e) => {
    e.stopPropagation()
    e.preventDefault()
})

/**
 * Handle drag over event to allow dropping files
 */
dropzone.addEventListener('dragover', (e) => {
    e.stopPropagation()
    e.preventDefault()
})

/**
 * Handle drop event when files are dropped onto the dropzone
 */
dropzone.addEventListener('drop', (e) => {
    e.stopPropagation()
    e.preventDefault()

    const dt = e.dataTransfer
    const files = dt.files

    handleFiles(files)
})

/**
 * Process and validate uploaded files
 * @param {FileList} files - List of files to process
 */
function handleFiles(files) {
    // Loop through each file in the FileList
    for (let i = 0; i < files.length; i++) {
        const file = files[i];

        // Skip non-image files
        if (!file.type.startsWith("image/")) {
            continue;
        }
        
        // Create preview element in the UI
        createPreview(file);
        console.log(file)
    }
}

/**
 * Create a preview element for an uploaded file
 * @param {File} file - The file to create a preview for
 */
function createPreview(file) {
    // Get the container where previews will be displayed
    const previewContainer = document.getElementById('dropzone-previews');

    // Generate HTML for the file preview
    const previewHTML = `<div class="dropzone-preview">
        <div class="dropzone-preview-image">
            <img src="${URL.createObjectURL(file)}" alt="${file.name}" class="obj">
        </div>
        <div class="dropzone-preview-info">
            <div class="dropzone-preview-details">
                <span class="dropzone-preview-filename">${file.name}</span>
                <span class="dropzone-preview-filesize">${(file.size / 1024).toFixed(2)} KB</span>
            </div>
            <div class="dropzone-preview-buttons">
                <button class="dropzone-preview-remove" type="button"><i class="fa-solid fa-trash"></i></button>
            </div>
        </div>
    </div>`;

    // Insert the preview HTML at the end of the preview container
    previewContainer.insertAdjacentHTML('beforeend', previewHTML);

    // Add event listener to the remove button
    const removeButton = previewContainer.lastElementChild.querySelector('.dropzone-preview-remove');
    removeButton.addEventListener('click', () => {
        // Remove the preview element from the DOM
        previewContainer.removeChild(removeButton.closest('.dropzone-preview'));
    });
}


</script>