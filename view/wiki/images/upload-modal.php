<div class="modal" id="uploadModal">
    <div class="modal-box">
        <div class="modal-header">
            Test Modal Box
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
        </div>
        <div class="modal-footer">
            <button class="button button-blue">upload</button>
        </div>
    </div>
</div>


<script>

const dropzone = document.getElementById('dropzone')
const fileInput = document.getElementById('dropzone-input')

fileInput.addEventListener('change', (e) => {
    console.log('i have a file, yum')
})

dropzone.addEventListener('click', (e) => {
    fileInput.click()
})

dropzone.addEventListener('dragenter', (e) => {
    e.stopPropagation()
    e.preventDefault()
})

dropzone.addEventListener('dragover', (e) => {
    e.stopPropagation()
    e.preventDefault()
})

dropzone.addEventListener('drop', (e) => {
    e.stopPropagation()
    e.preventDefault()

    const dt = e.dataTransfer
    const files = dt.files

    handleFiles(files)
})

function handleFiles(files) {
    for (let i = 0; i < files.length; i++) {
        const file = files[i];

        if (!file.type.startsWith("image/")) {
            continue;
        }

        const img = document.createElement("img");
        img.classList.add("obj");
        img.file = file;
        dropzone.appendChild(img); // Assuming that "preview" is the div output where the content will be displayed.

        const reader = new FileReader();
        reader.onload = (e) => {
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}


</script>