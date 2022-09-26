<link rel="stylesheet" href="<?= ABSURL ?>easymde/easymde.min.css">
<script src="<?= ABSURL ?>easymde/easymde.min.js"></script>

<main class="container create">
    <div class="heading"><h1><?= $title ?></h1></div>

    <?php if($errorstring != ''): ?>

        <div class="errorstring"><p><i class="fas fa-exclamation-triangle"></i> <?= $errorstring ?></p></div>

    <?php endif; ?>

    <div class="form">
        <form method="post" action="<?= $values['submit'] ?>" id="form">
            <div class="form-input">
                <p class="placeholder">Filename</p>
                <input class="input" name="filename" type="text" value="<?= $values['filename'] ?>" id="input-filename" />
                <p class="placeholder error hidden"><i class="fas fa-info-circle"></i> invalid filename</p>
            </div>
            <div class="form-input">
                <p class="placeholder">Directory</p>
                <input class="input" name="directory" type="text" value="<?= $values['directory'] ?>" id="input-directory" />
                <p class="placeholder error hidden"><i class="fas fa-info-circle"></i> invalid directory</p>
            </div>
            <div class="form-input">
                <p class="placeholder">Wiki Text</p>
                <textarea id="simplemde" class="input" name="text"><?= $values['text'] ?></textarea>
            </div>
        </form>

        <?php if ($second_submit !== false): ?>
            
            <form method="post" action="<?= $second_submit['submit'] ?>" id="second-form">
                <input type="hidden" class="hidden" name="delete" value="delete" />
            </form>
            
            <div class="form-buttons grid-2">
                <div class="form-button right">
                    <button class="button" id="submit-button" onclick="return submitForm()"><?= $values['button'] ?></button>
                </div>
                <div class="form-button left">
                    <button class="button valid danger" onclick="return submitSecondForm()"><?= $second_submit['button'] ?></button>
                </div>
            </div>

        <?php else: ?>

            <div class="form-buttons">
                <div class="form-button center">
                    <button class="button" id="submit-button" onclick="return submitForm()"><?= $values['button'] ?></button>
                </div>
            </div>

        <?php endif; ?>
    </div>
</main>
<script>

const easymde = new EasyMDE({element: document.getElementById('simplemde'), spellChecker: false})

const inputFilename = document.getElementById('input-filename')
const inputDirectory = document.getElementById('input-directory')
const submitButton = document.getElementById('submit-button')
const form = document.getElementById('form')
const secondForm = document.getElementById('second-form')

let filenameValid = false
let directoryValid = true

inputFilename.addEventListener('focusout', () => {
    reg = new RegExp('^.+[.]{1}md$')
    if (inputFilename.value.match(reg) == null && inputFilename.value != '') {
        inputFilename.value = inputFilename.value + '.md'
    }
    validateDirectory();
})

inputFilename.addEventListener('keypress', (e) => {
    replaceSpaceWithMinus(e)
})

inputFilename.addEventListener('input', () => {
    validateFilename()
})

inputDirectory.addEventListener('focusout', () => {
    reg = new RegExp('^.+\/$')
    if (inputDirectory.value.match(reg) == null && inputDirectory.value != '/') {
        inputDirectory.value = inputDirectory.value + '/'
    }
    validateDirectory();
})

inputDirectory.addEventListener('keypress', (e) => {
    firstLetterSlash(e)
    replaceSpaceWithMinus(e)
    replaceDoubleSlashes(e)
})

inputDirectory.addEventListener('input', () => {
    validateDirectory();
})

function validateFilename() {
    reg = new RegExp('^[a-zA-Z0-9._-]+$');
    if (inputFilename.value.match(reg) == null) {
        inputFilename.nextElementSibling.classList.remove('hidden')
        filenameValid = false
    } else {
        inputFilename.nextElementSibling.classList.add('hidden')
        filenameValid = true
    }

    validate()
}

function validateDirectory() {
    reg = new RegExp('^[a-zA-Z0-9/_-]+$');
    if (inputDirectory.value.match(reg) == null) {
        inputDirectory.nextElementSibling.classList.remove('hidden')
        directoryValid = false
    } else {
        inputDirectory.nextElementSibling.classList.add('hidden')
        directoryValid = true
    }

    validate()
}

function validate() {
    if (directoryValid && filenameValid) {
        submitButton.classList.add('valid')
    } else {
        submitButton.classList.remove('valid')
    }
}

function isValid() {
    if (directoryValid && filenameValid) {
        return true
    } else {
        return false
    }
}

function submitForm() {
    if (isValid()) {
        return form.submit();
    } else {
        return false
    }
}

async function submitSecondForm() {
    await confirmJs('do you really want to delete this file?')
        .then(() => {
            return secondForm.submit()
        })
        .catch(() => {
            return false
        })
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

function replaceDoubleSlashes(e) {
    if (e.key === '/'){
        // get old value
        var start = e.target.selectionStart;
        var end = e.target.selectionEnd;
        var oldValue = e.target.value;

        console.log(start)
        console.log(end)
        console.log(oldValue.charAt(start - 1))
        console.log(e.target.value)

        // if the end or start is a slash replace it
        if (oldValue.charAt(start - 1) !== '/' && oldValue.charAt(end) !== '/') {

            // write the slash
            var newValue = oldValue.slice(0, start) + '/' + oldValue.slice(end)
            e.target.value = newValue;
            // replace cursor
            e.target.selectionStart = e.target.selectionEnd = start + 1;

        } else {

            e.target.value = oldValue
            e.target.selectionStart = e.target.selectionEnd = start;

        }

        e.preventDefault();
    }
}

function firstLetterSlash(e) {
    if (e.target.selectionStart === 0 && e.key !== '/') {
        oldStart = e.target.selectionStart
        e.target.value = '/' + e.target.value
        e.target.selectionStart = e.target.selectionEnd = oldStart + 1;
    }
}

validateFilename()
validateDirectory()

</script>