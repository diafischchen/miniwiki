<!-- i think this is an unused file but im not sure -->
<main class="container manage">
    <div class="heading"><h1>Rename Directory</h1></div>
    <div class="form">
        <form method="post" action="<?= ABSURL ?>directories/edit">
            <div class="form-input">
                <p class="placeholder">Directory Name</p>
                <input class="input" value="<?= $path ?>" id="dirname" type="text" name="dirname" />
                <p class="placeholder error hidden"><i class="fas fa-info-circle"></i> invalid directory name</p>
            </div>
            <div class="form-buttons">
                <div class="form-button center">
                    <button class="button" id="submit" type="submit" onclick="return inputDirnameValid">Rename</button>
                </div>
            </div>
        </form>
    </div>
</main>

<script>

const inputDirname = document.getElementById('dirname')
const submitButton = document.getElementById('submit')

let inputDirnameValid = true

function validate() {

    reg = new RegExp('^[a-zA-Z0-9/_-]+$')

    if (inputDirname.value.match(reg) == null) {
        inputDirname.nextElementSibling.classList.remove('hidden')
        submitButton.classList.remove('valid')
        inputDirnameValid = false
    } else {
        inputDirname.nextElementSibling.classList.add('hidden')
        submitButton.classList.add('valid')
        inputDirnameValid = true
    }

}

inputDirname.addEventListener('input', () => {
    validate()
})

validate()

</script>