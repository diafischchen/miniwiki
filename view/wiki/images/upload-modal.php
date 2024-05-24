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

dropzone.addEventListener('dragover', (e) => {
    e.preventDefault()
})

dropzone.addEventListener('drop', (e) => {
    e.preventDefault()
    
    
    console.log(e.dataTransfer.items)
})

</script>