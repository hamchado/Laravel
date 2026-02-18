// Service Worker لتطبيق Laravel PWA
const CACHE_NAME = 'laravel-app-v1.0.0';
const OFFLINE_URL = '/offline.html';

// الملفات التي سيتم تخزينها في الكاش
const STATIC_CACHE_FILES = [
  '/',
  '/manifest.json',
  '/css/app.css',
  '/js/app.js',
  '/icons/icon-72x72.png',
  '/icons/icon-96x96.png',
  '/icons/icon-128x128.png',
  '/icons/icon-144x144.png',
  '/icons/icon-152x152.png',
  '/icons/icon-192x192.png',
  '/icons/icon-512x512.png',
  OFFLINE_URL
];

// تثبيت Service Worker
self.addEventListener('install', event => {
  console.log('[Service Worker] Installing...');
  
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        console.log('[Service Worker] Caching app shell');
        return cache.addAll(STATIC_CACHE_FILES);
      })
      .then(() => {
        console.log('[Service Worker] Install completed');
        return self.skipWaiting();
      })
  );
});

// تفعيل Service Worker
self.addEventListener('activate', event => {
  console.log('[Service Worker] Activating...');
  
  // تنظيف الكاش القديم
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheName !== CACHE_NAME) {
            console.log('[Service Worker] Deleting old cache:', cacheName);
            return caches.delete(cacheName);
          }
        })
      );
    }).then(() => {
      console.log('[Service Worker] Activation completed');
      return self.clients.claim();
    })
  );
});

// اعتراض الطلبات
self.addEventListener('fetch', event => {
  // تجاهل طلبات POST وغير GET
  if (event.request.method !== 'GET') return;
  
  // تجاهل طلبات الخلفية مثل analytics
  if (event.request.url.includes('chrome-extension') || 
      event.request.url.includes('sockjs') ||
      event.request.url.includes('analytics')) {
    return;
  }
  
  event.respondWith(
    caches.match(event.request)
      .then(response => {
        // إذا كان الملف موجود في الكاش
        if (response) {
          console.log('[Service Worker] Serving from cache:', event.request.url);
          return response;
        }
        
        // إذا لم يكن موجود في الكاش، حمله من الشبكة
        console.log('[Service Worker] Fetching from network:', event.request.url);
        
        return fetch(event.request)
          .then(networkResponse => {
            // إذا كان الرد ناجحاً، خزنه في الكاش
            if (networkResponse && networkResponse.status === 200 && 
                networkResponse.type === 'basic') {
              const responseToCache = networkResponse.clone();
              caches.open(CACHE_NAME)
                .then(cache => {
                  cache.put(event.request, responseToCache);
                });
            }
            return networkResponse;
          })
          .catch(error => {
            console.log('[Service Worker] Fetch failed; returning offline page:', error);
            
            // إذا كانت الصفحة الرئيسية، عرض صفحة Offline
            if (event.request.mode === 'navigate') {
              return caches.match(OFFLINE_URL);
            }
            
            // لطلبات الصور، عرض صورة افتراضية
            if (event.request.destination === 'image') {
              return caches.match('/icons/icon-192x192.png');
            }
            
            // لطلبات CSS/JS، عرض محتوى افتراضي
            return new Response('عذراً، أنت غير متصل بالإنترنت', {
              status: 503,
              statusText: 'Service Unavailable',
              headers: new Headers({
                'Content-Type': 'text/plain; charset=utf-8'
              })
            });
          });
      })
  );
});

// معالجة دفع الإشعارات
self.addEventListener('push', event => {
  console.log('[Service Worker] Push received');
  
  const data = event.data ? event.data.json() : {};
  const title = data.title || 'تطبيق التعلم الذكي';
  const options = {
    body: data.body || 'لديك إشعار جديد',
    icon: '/icons/icon-192x192.png',
    badge: '/icons/icon-96x96.png',
    dir: 'rtl',
    lang: 'ar',
    vibrate: [200, 100, 200],
    data: {
      url: data.url || '/'
    }
  };
  
  event.waitUntil(
    self.registration.showNotification(title, options)
  );
});

// النقر على الإشعار
self.addEventListener('notificationclick', event => {
  console.log('[Service Worker] Notification click received');
  
  event.notification.close();
  
  event.waitUntil(
    clients.matchAll({ type: 'window', includeUncontrolled: true })
      .then(clientList => {
        // إذا كان هناك نافذة مفتوحة، ركز عليها
        for (const client of clientList) {
          if (client.url === event.notification.data.url && 'focus' in client) {
            return client.focus();
          }
        }
        // إذا لم يكن هناك نافذة مفتوحة، افتح واحدة جديدة
        if (clients.openWindow) {
          return clients.openWindow(event.notification.data.url);
        }
      })
  );
});

// تحديث التطبيق في الخلفية
self.addEventListener('message', event => {
  if (event.data === 'SKIP_WAITING') {
    self.skipWaiting();
  }
});
