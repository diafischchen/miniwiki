// Get All Modal Openers in Document
const modalOpeners = document.querySelectorAll('.modal-opener')

// Register a Event Listener for each Modal Opener
modalOpeners.forEach((opener) => {
    opener.addEventListener('click', () => {
        // get the related modal
        const modal = document.getElementById(opener.dataset.modal)

        // open the modal
        modal.classList.add('animate')
        modal.classList.add('active')

        // make the modal animate in
        setTimeout(() => {
            modal.classList.remove('animate')
        }, 10);

        // register the closing function as anonymous function
        const closeModal = () => {
            // animate the modal out
            modal.classList.add('animate')

            setTimeout(() => {
                // close the modal when animation is done
                modal.classList.remove('animate')
                modal.classList.remove('active')
            }, 300)
        }

        // get all modal closers and register a click event
        modal.querySelectorAll('.modal-closer').forEach((closer) => {
            closer.addEventListener('click', () => {
                closeModal()
            })
        })

        // register the click event on the background of the modal itself
        modal.addEventListener('click', (e) => {
            if (e.target == modal) {
                closeModal()
            }
        })
    })
})