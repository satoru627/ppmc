const CACHE_VERSION = 'ppmc-pwa-v1';
const STATIC_CACHE = `${CACHE_VERSION}-static`;
const RUNTIME_CACHE = `${CACHE_VERSION}-runtime`;

const PRECACHE_URLS = [
  '/',
  '/manifest.webmanifest',
  '/icons/icon-192.png',
  '/icons/icon-512.png',
  '/icons/icon-maskable-512.png',
  '/assets/logo.png',
  '/assets/hero-background.jpg'
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(STATIC_CACHE)
      .then((cache) => cache.addAll(PRECACHE_URLS))
      .catch(() => undefined)
  );

  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys()
      .then((keys) => Promise.all(
        keys
          .filter((key) => key.startsWith('ppmc-pwa-') && !key.startsWith(CACHE_VERSION))
          .map((key) => caches.delete(key))
      ))
      .then(() => self.clients.claim())
  );
});

const isCacheableAsset = (request, url) => {
  if (url.origin !== self.location.origin || request.method !== 'GET') {
    return false;
  }

  return ['image', 'font', 'style', 'script'].includes(request.destination)
    || url.pathname.startsWith('/assets/')
    || url.pathname.startsWith('/icons/')
    || url.pathname.startsWith('/build/')
    || url.pathname.startsWith('/storage/');
};

const networkFirstPage = async (request) => {
  try {
    const response = await fetch(request);
    return response;
  } catch (error) {
    const cachedHome = await caches.match('/');

    return cachedHome || new Response(
      '<!doctype html><html lang="fr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>PPMC hors ligne</title></head><body style="font-family:system-ui,sans-serif;padding:2rem;color:#071B3B"><h1>PPMC est hors ligne</h1><p>Verifiez votre connexion puis reessayez.</p></body></html>',
      {
        headers: { 'Content-Type': 'text/html; charset=utf-8' },
        status: 503,
        statusText: 'Service Unavailable'
      }
    );
  }
};

const staleWhileRevalidate = async (request) => {
  const cached = await caches.match(request);
  const networkPromise = fetch(request)
    .then((response) => {
      if (response && response.ok) {
        const responseClone = response.clone();
        caches.open(RUNTIME_CACHE).then((cache) => cache.put(request, responseClone));
      }

      return response;
    })
    .catch(() => undefined);

  return cached || networkPromise || fetch(request);
};

self.addEventListener('fetch', (event) => {
  const { request } = event;

  if (request.method !== 'GET') {
    return;
  }

  const url = new URL(request.url);

  if (request.mode === 'navigate') {
    event.respondWith(networkFirstPage(request));
    return;
  }

  if (isCacheableAsset(request, url)) {
    event.respondWith(staleWhileRevalidate(request));
  }
});
