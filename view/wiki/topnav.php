<div class="topnav">
    <div class="topnav-item topnav-bar">
        <div class="topnav-mobile-toggle">
            <div><i class="fas fa-cog"></i></div>
        </div>

        <div class="topnav-name">
            <a href="<?= ABSURL ?>wiki"><?= APP_NAME ?></a>
        </div>
    </div>

    <div class="topnav-item topnav-nav">
        <a href="<?= ABSURL ?>wiki/<?= $path ?>.md/edit" class="button">
            Edit
        </a>
        <a href="<?= ABSURL ?>wiki/<?= $path ?>.md/download" class="button">
            Download
        </a>
        <a href="<?= ABSURL ?>create" class="button">
            Create new
        </a>
    </div>
</div>

<script>

const topnavMobileToggle = document.querySelector('.topnav-mobile-toggle')

topnavMobileToggle.addEventListener('click', () => {
    const topnav = topnavMobileToggle.closest('.topnav')
    const topnavNav = topnav.querySelector('.topnav-nav')

    if (topnav.classList.contains('mobile-active')) {

        topnavNav.style.maxHeight = '0px'
        topnav.style.gap = '0px'

        setTimeout(() => {
            topnav.classList.remove('mobile-active')
            topnav.removeAttribute('style')
        }, 300)

    } else {

        topnav.classList.add('mobile-active')
        topnavNav.style.maxHeight = '0px'

        setTimeout(() => {
            topnavNav.style.maxHeight = topnavNav.scrollHeight + 'px'
        }, 5)

    }
})

</script>