const CACHE_NAME = "app-cache-v1";
const CACHE_EXPIRY = 1000 * 60 * 60 * 12; // 12 jam dalam milidetik
const urlsToCache = [
    "/",
    "/admin",
    "/peserta",
    "/mengenai_kami",
    "/kontak",
    "/artikel",
    "/layanan",
    "/layanan/psikotes-sim",
    "/link-psikotes",

    "/images/bg1.png", "/images/bg2.png", "/images/bg3.png", "/images/bg4.png", "/images/bg5.png",
    "/images/bg6.png", "/images/bg7.png", "/images/bg8.png", "/images/bg9.png", "/images/bg10.png",
    "/images/bg11.png", "/images/bg12.png", "/images/bg13.png", "/images/bg14.png", "/images/bg15.png",
    "/images/bg16.png", "/images/bg17.png", "/images/bg18.png", "/images/bg19.png", "/images/bg20.png",
    "/images/bg21.png", "/images/bg22.png", "/images/bg23.png",
    "/images/HPI.png", "/images/logo1.png", "/images/Muhtar.png", "/images/Syafiq_Marzuki.png",
    "/images/album/IMG-20211002-WA0019.png", "/images/album/IMG-20211130-WA0016.png",

    "/images/bg1.webp", "/images/bg2.webp", "/images/bg3.webp", "/images/bg4.webp", "/images/bg5.webp",
    "/images/bg6.webp", "/images/bg7.webp", "/images/bg8.webp", "/images/bg9.webp", "/images/bg10.webp",
    "/images/bg11.webp", "/images/bg12.webp", "/images/bg13.webp", "/images/bg14.webp", "/images/bg15.webp",
    "/images/bg16.webp", "/images/bg17.webp", "/images/bg18.webp", "/images/bg19.webp", "/images/bg20.webp",
    "/images/bg21.webp", "/images/bg22.webp", "/images/bg23.webp",
    "/images/HPI.webp", "/images/logo1.webp", "/images/Muhtar.webp", "/images/Syafiq_Marzuki.webp",
    "/images/album/IMG-20211002-WA0019.webp", "/images/album/IMG-20211130-WA0016.webp",

    "/css/additional.css",
    "/js/myfunction.js",
];

// Install Service Worker
self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => cache.addAll(urlsToCache))
        // caches.open(CACHE_NAME).then(async (cache) => {
        //     for (const url of urlsToCache) {
        //         try {
        //             const response = await fetch(url);
        //             if (response.ok) {
        //                 await cache.put(url, response);
        //                 console.log(`✅ Cached: ${url}`);
        //             } else {
        //                 console.warn(`⚠ Gagal cache (status ${response.status}): ${url}`);
        //             }
        //         } catch (err) {
        //             console.warn(`❌ Error fetch: ${url}`, err);
        //         }
        //     }
        // })
    );
});

// Fetch dengan cek expiry
self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches.open(CACHE_NAME).then(async (cache) => {
            const cachedResponse = await cache.match(event.request);
            const timestampResponse = await cache.match(event.request.url + "_timestamp");

            if (cachedResponse && timestampResponse) {
                const timestamp = parseInt(await timestampResponse.text());
                const isExpired = (Date.now() - timestamp) > CACHE_EXPIRY;

                if (!isExpired) {
                    // ✅ Cache masih fresh (kurang dari 12 jam)
                    return cachedResponse;
                } else {
                    console.log("⏳ Cache expired untuk:", event.request.url);
                    cache.delete(event.request);
                    cache.delete(event.request.url + "_timestamp");
                }
            }

            // Fetch dari network dan update cache
            const networkResponse = await fetch(event.request);
            cache.put(event.request, networkResponse.clone());
            cache.put(event.request.url + "_timestamp", new Response(Date.now().toString()));
            return networkResponse;
        })
    );
});