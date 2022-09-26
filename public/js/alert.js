/**
 * following functions replace the alert() and confirm() function from javascript
 * 
 * we use that to style our alerts to match the rest of our app
 */

 async function alertJs(message) {

    // Build Modal
    const alertJsModal = `
    <div class="alertjs-box">
        <div class="alertjs-message">${message}</div>
        <div class="alertjs-buttons">
            <div class="alertjs-button alertjs-button-ok">Ok</div>
        </div>
    </div>`

    // Fade in Modal
    const alertJsBack = document.getElementById('alertjs-back');

    alertJsBack.insertAdjacentHTML("beforebegin", alertJsModal);
    alertJsBack.classList.add('active');
    alertJsBack.classList.add('animate');

    setTimeout(() => {
        document.querySelector('.alertjs-box').classList.add('active');
        alertJsBack.classList.remove('animate');
    }, 5)

    // Await User Input
    await (async () => {
        return new Promise((resolve) => {
            alertJsBack.addEventListener('click', () => {
                resolve()
            })
            document.querySelector(".alertjs-button-ok").addEventListener('click', () => {
                resolve()
            })
        });
    })()
        .then(() => {
            // Resolve User Input
            document.querySelector('.alertjs-box').classList.remove('active');
            alertJsBack.classList.add('animate');
            setTimeout(() => {
                document.querySelector('.alertjs-box').outerHTML = '';
                alertJsBack.classList.remove('active');
                alertJsBack.classList.remove('animate');
            }, 300)
            return Promise.resolve(true);
        })

}

async function confirmJs(message) {
    // Build Modal
    const alertJsModal = `
    <div class="alertjs-box">
        <div class="alertjs-message">${message}</div>
        <div class="alertjs-buttons">
            <div class="alertjs-button alertjs-button-cancel">Cancel</div>
            <div class="alertjs-button alertjs-button-ok">Ok</div>
        </div>
    </div>`

    // Fade in Modal
    const alertJsBack = document.getElementById('alertjs-back');

    alertJsBack.insertAdjacentHTML("beforebegin", alertJsModal);
    alertJsBack.classList.add('active');
    alertJsBack.classList.add('animate');

    setTimeout(() => {
        document.querySelector('.alertjs-box').classList.add('active');
        alertJsBack.classList.remove('animate');
    }, 5)

    // Await User Input
    await (async () => {
        return new Promise((resolve, reject) => {
            alertJsBack.addEventListener('click', () => {
                reject();
            })
            document.querySelector(".alertjs-button-cancel").addEventListener('click', () => {
                reject();
            })
            document.querySelector(".alertjs-button-ok").addEventListener('click', () => {
                resolve();
            })
        });
    })()
        .then(() => {
            // Resolve User Input
            return Promise.resolve(true);
        })
        .catch(() => {
            return Promise.reject(false)
        })
        .finally(() => {
            document.querySelector('.alertjs-box').classList.remove('active');
            alertJsBack.classList.add('animate');
            setTimeout(() => {
                document.querySelector('.alertjs-box').outerHTML = '';
                alertJsBack.classList.remove('active');
                alertJsBack.classList.remove('animate');
            }, 300)
        });
}