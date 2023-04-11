const CACHE_NAME = 'my-cache';

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                return cache.addAll([
                    '/',
                    '/assets/css/style.css',
                    '/assets/css/bootstrap.min.css',
                    '/assets/js/index.js',
                    '/assets/js/bootstrap.min.js',
                    '/assets/js/axios.min.js',
                    '/assets/js/jquery-3.6.4.min.js',
                    '/assets/js/vue.min.js',
                    '/assets/js/VueQrcodeReader.umd.min.js'
                ]);
            })
    );
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys()
            .then(keys => {
                return Promise.all(
                    keys.filter(key => key !== CACHE_NAME)
                        .map(key => caches.delete(key))
                );
            })
    );
});

self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                if (response) {
                    return response;
                }
                return fetch(event.request);
            })
    );
});