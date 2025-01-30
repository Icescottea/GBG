// Service Worker Installation
self.addEventListener("install", function(event) {
    event.waitUntil(
        caches.open("gasbygas-cache").then(function(cache) {
            return cache.addAll([
                "/",
                "/css/app.css",
                "/js/app.js",
                "/img/icons/favicon.png",
                "/img/icons/logo.jpeg",
                '/manifest.json'
            ]);
        })
    );
});

// Service Worker Activation
self.addEventListener("activate", function(event) {
    event.waitUntil(self.clients.claim());
});

// Fetch Event - Serve Cached Files When Offline
self.addEventListener("fetch", function(event) {
    event.respondWith(
        caches.match(event.request).then(function(response) {
            return response || fetch(event.request);
        })
    );
});
