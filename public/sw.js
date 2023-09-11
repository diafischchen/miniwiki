const cacheName = 'v1'
const precache = [
    '/',
    '/css/alertjs.css',
    '/css/fonts.css',
    '/css/login.css',
    '/css/style.css',
    '/js/alert.js',
    '/js/modal.js',
    '/favicon.ico',
    '/manifest.json',
]


// Call Install Event
self.addEventListener('install', e => {
    //console.log('Service Worker: Installed');
    e.waitUntil(
        caches.open(cacheName).then(function(cache) {
            return cache.addAll(precache);
        })
    );
});

// Call Activate Event
self.addEventListener('activate', e => {
    //console.log('Service Worker: Activated');
    // Remove unwanted caches
    e.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cache => {
                    if (cache !== cacheName) {
                        //console.log('Service Worker: Clearing Old Cache');
                        return caches.delete(cache);
                    }
                })
            );
        })
    );
});

// Call Fetch Event
self.addEventListener('fetch', e => {
    //console.log('Service Worker: Fetching');
    e.respondWith(
        fetch(e.request)
        .then(res => {
            // Make copy/clone of response
            const resClone = res.clone();
            // Open cahce
            caches.open(cacheName).then(cache => {
                // Add response to cache
                cache.put(e.request, resClone);
            });
            return res;
        })
        .catch(err => caches.match(e.request).then(res => res))
    );
});