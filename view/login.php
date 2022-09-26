<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wiki | Login</title>
    <link rel="shortcut icon" href="<?= ABSURL ?>favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="192x192" href="<?= ABSURL ?>img/maskable192.png">
    <link rel="manifest" href="<?= ABSURL ?>manifest.json" crossorigin="use-credentials">
    <meta name="theme-color" content="#475569">
    <meta name="description" content="MK Wiki">
    <link rel="stylesheet" href="<?= ABSURL ?>css/fonts.css">
    <link rel="stylesheet" href="<?= ABSURL ?>css/login.css?v=<?= VERSION ?>">
</head>
<body>
<main>
    <div class="login-box">
        <div class="head">
            Login
        </div>
        <div class="content">
            <form class="login-form" method="post" action="<?= ABSURL ?>login">
                <div class="input" data-placeholder="Username">
                    <input type="text" name="username" />
                </div>

                <div class="input" data-placeholder="Password">
                    <input type="password" name="password" />
                </div>

                <input class="hidden" type="checkbox" name="keep_logged_in" checked />

                <div class="button">
                    <button type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>

document.querySelectorAll('.input input').forEach((input) => {

    if (input.value != '') {
        input.closest('.input').classList.add('focus')
    }

    input.addEventListener('focus', () => {
        input.closest('.input').classList.add('focus')
    })

    input.addEventListener('blur', () => {
        if (input.value == '') {
            input.closest('.input').classList.remove('focus')
        } 
    })
})

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker
            .register('<?= ABSURL ?>sw.js')
            .then(reg => {
                console.log('Service Worker: Registered');
                localStorage.setItem('sw-registered', true);
            })
            .catch(err => {
                console.log(`Service Worker: Registration failed ${err}`);
                localStorage.setItem('sw-registered', false);
            })
    })
}

</script>
</body>
</html>