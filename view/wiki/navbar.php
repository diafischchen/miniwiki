<nav class="nav-container">
    <div class="nav-links">
        <a href="<?= ABSURL ?>logout" class="file">
            <div class="mr-10"><i class="fas fa-sign-out-alt"></i></div>
            <div>Logout</div>
        </a>
        <a href="<?= ABSURL ?>directories" class="file<?= $current == 'directory-manager' ? ' current' : '' ?>">
            <div class="mr-10"><i class="fas fa-toolbox"></i></div>
            <div>Directory Manager</div>
        </a>
        <a href="<?= ABSURL ?>images" class="file<?= $current == 'image-manager' ? ' current' : '' ?>">
            <div class="mr-10"><i class="fas fa-images"></i></div>
            <div>Image Manager</div>
        </a>
        <hr />
        <?php $this->render('/wiki/navitems', ['items' => $files, 'dir' => '', 'current' => $current]); ?>
    </div>
</nav>

<div class="mobile-nav-close">
    <i class="fas fa-times"></i>
</div>

<div class="mobile-nav-open">
    <i class="far fa-compass"></i>
</div>

<script>

// mobile navbar animation open and close
const mobileNavOpen = document.querySelector('.mobile-nav-open')
const mobileNavClose = document.querySelector('.mobile-nav-close')
const navContainer = document.querySelector('.nav-container')

mobileNavOpen.addEventListener('click', () => {
    navContainer.classList.add('mobile-active')
    navContainer.classList.add('animate')
    openCurrentTab()

    setTimeout(() => {
        navContainer.classList.remove('animate')
    }, 5)
})

mobileNavClose.addEventListener('click', () => {
    navContainer.classList.add('animate')
    
    setTimeout(() => {
        navContainer.classList.remove('animate')
        navContainer.classList.remove('mobile-active')
    }, 300)
})

// navbar folder open and close animation

const folderTogglers = document.querySelectorAll('.folder > .folder-toggle')
const currentOpenFolderTab = document.querySelector('.folder > .folder-items > .file.current')

folderTogglers.forEach((folderToggle) => {
    folderToggle.addEventListener('click', () => {
        const folder = folderToggle.closest('.folder')

        if (folder.classList.contains('active')) {

            // animate out
            animateFolderOut(folder)

        } else {

            // animate in
            animateFolderIn(folder)

        }
    })
})

function animateFolderIn(folder, additionalHeight = 0) {
    // animate in
    folder.classList.add('active')
    folder.querySelector('.folder-items').style.maxHeight = '0px'

    // if subdirectory add additional space
    if (folder.closest('.folder-items') !== null) {
        animateFolderIn(folder.closest('.folder-items').closest('.folder'), (folder.querySelector('.folder-items').scrollHeight + additionalHeight))
    }

    setTimeout(() => {
        folder.querySelector('.folder-items').style.maxHeight = (folder.querySelector('.folder-items').scrollHeight + additionalHeight) + 'px'
    }, 5)
}

function animateFolderOut(folder) {
    // animate out
    folder.querySelector('.folder-items').style.maxHeight = '0px'

    setTimeout(() => {
        folder.classList.remove('active')
    }, 300)
}

function rekOpening(folder) {
    if (folder.closest('.folder-items') !== null) {
        rekOpening(folder.closest('.folder-items').closest('.folder'))
    }
    animateFolderIn(folder)
}

function openCurrentTab() {
    if (currentOpenFolderTab !== null) {
        rekOpening(currentOpenFolderTab.closest('.folder'))
    }
}

openCurrentTab()


</script>