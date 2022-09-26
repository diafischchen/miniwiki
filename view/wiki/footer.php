<div class="alertjs-back" id="alertjs-back"></div>
<script>
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