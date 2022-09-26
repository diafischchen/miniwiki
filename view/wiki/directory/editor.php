<main class="container manage">
    <div class="heading"><h1><?= $title ?></h1></div>
    <?php if(isset($errorstring) && $errorstring != ''): ?>

        <div class="errorstring"><p><i class="fas fa-exclamation-triangle"></i> <?= $errorstring ?></p></div>

    <?php endif; ?>
    <div class="form">
        <form method="post" action="<?= $submit ?>">
            <div class="form-input">
                <p class="placeholder">Directory Name</p>
                <input class="input" value="<?= $dirname ?>" id="dirname" type="text" name="dirname" />
                <p class="placeholder error hidden"><i class="fas fa-info-circle"></i> invalid directory name</p>
            </div>
            <input type="hidden" class="hidden" name="dir" value="<?= $dir ?>" />
            <div class="form-buttons">
                <div class="form-button center">
                    <button class="button" id="submit" type="submit" onclick="return inputDirnameValid"><?= $button ?></button>
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

    reg = new RegExp('^[a-zA-Z0-9_-]+$')

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

function replaceSpaceWithMinus(e) {
    if (e.key === ' '){
        // get old value
        var start = e.target.selectionStart;
        var end = e.target.selectionEnd;
        var oldValue = e.target.value;

        // replace space and change input value
        var newValue = oldValue.slice(0, start) + '-' + oldValue.slice(end)
        e.target.value = newValue;

        // replace cursor
        e.target.selectionStart = e.target.selectionEnd = start + 1;

        e.preventDefault();
    }
}

inputDirname.addEventListener('input', () => {
    validate()
})

inputDirname.addEventListener('keydown', (e) => {
    replaceSpaceWithMinus(e)
})

validate()

</script>