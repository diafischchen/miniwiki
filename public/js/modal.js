// Delegate to the document so modal-openers added to the DOM later still work
document.addEventListener('click', (e) => {
    const opener = e.target.closest('.modal-opener')

    if (!opener) {
        return
    }

    // get the related modal
    const modal = document.getElementById(opener.dataset.modal)

    if (!modal) {
        return
    }

    // open the modal
    modal.classList.add('animate')
    modal.classList.add('active')

    // make the modal animate in
    setTimeout(() => {
        modal.classList.remove('animate')
    }, 10);
})

// Delegate closer clicks (button or clicking the modal background) the same way
document.addEventListener('click', (e) => {
    const modal = e.target.closest('.modal')

    if (!modal) {
        return
    }

    const clickedBackground = e.target == modal
    const clickedCloser = e.target.closest('.modal-closer')

    if (!clickedBackground && !clickedCloser) {
        return
    }

    // animate the modal out
    modal.classList.add('animate')

    setTimeout(() => {
        // close the modal when animation is done
        modal.classList.remove('animate')
        modal.classList.remove('active')
    }, 300)
})