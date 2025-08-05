@php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
@endphp
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charSet="utf-8" />
        <title>{{ $title }}</title>
        <meta property="og:title" content="{{ $title }}" />
        <meta name="description" content="Psikotes Online App adalah aplikasi psikotest berbasis online web, dimana dapat diakses di perangkat manapun." />
        <meta property="og:description" content="Psikotes Online App, adalah aplikasi psikotest berbasis online web, dimana dapat diakses di perangkat manapun." />
        <meta name="keywords" content="Syafiq, PT. Solusi, Syafiq Psikotest, PHP, Laravel" />
        <meta name="author" content="Syafiq. Syahri Ramadhan Wiraasmara (ARI)" />
        <meta name="publisher" content="Syafiq. Syahri Ramadhan Wiraasmara (ARI)" />
        <meta name="developer" content="Syahri Ramadhan Wiraasmara (ARI)" />
        <meta name="copyright" content="Syafiq. Syahri Ramadhan Wiraasmara (ARI). Year: {{ date('Y'); }}" />
        <link rel="author" href="https://github.com/ariwiraasmara" />
        <link rel="repository" href="https://github.com/ariwiraasmara/syafiq_psikotest_backend_laravel" />
        <link rel="license" href="https://github.com/ariwiraasmara/syafiq_psikotest_backend_laravel?tab=AGPL-3.0-1-ov-file#" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
        <meta property="og:type" content="application, website" />
        <meta property="og:locale" content="id_ID" />
        <meta name="theme-color" content="rgba(200, 200, 255, 0.9)" />
        <meta http-equiv="X-Content-Type-Options" content="nosniff" />
        <meta name="referrer" content="no-referrer" />

        <meta property="og:url" content="{{ $pathURL }}" />
        <link rel="canonical" href="{{ $pathURL }}" />
        <link rel="breadcrumb" href="{{ $pathURL }}" />
        <meta name="robots" content="{{ $robots }}" />

        {{-- Nanti url href diubah dan disesuaikan --}}
        <link rel="icon" href="{{ asset('images/logo1.webp') }}" sizes="256x256" type="image/x-icon" />
        <link rel="apple-touch-icon" href="{{ asset('images/logo1.webp') }}" />
        <link rel="apple-touch-icon-precomposed" sizes="180x180" href="{{ asset('images/logo1.webp') }}" />
        <meta property="og:image" content="{{ asset('images/logo1.webp') }}" />

        @if($onetime)
        <meta name="XSRF-TOKEN" content="{{ csrf_token() }}" />
        <meta name="X-UNIQUE" content="{{ $unique }}" />
        @endif

        <link rel="stylesheet" href="{{ asset('/css/additional.css') }}" />
        {{-- <link rel="stylesheet" href="{{ tailwindcss('css/app.css') }}" /> --}}
        <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />
    </head>
    <body id="{{ 'app-'.env('APP_ENV').'-content' }}" class="">
        <nav aria-label="breadcrumb" id="nav-breadcrumb" class="font-bold bg-black {{ $is_breadcrumb_hidden; }}">
            <span id="breadcrumb" className="mr-4 ml-4 font-bold">{{ $breadcrumb; }}</span>
        </nav>
        @yield('content')

        <script defer nonce="{{ base64_encode(random_bytes(16)) }}" type="module" src="{{ asset('/js/myfunction.js') }}"></script>
        <script defer nonce="{{ base64_encode(random_bytes(16)) }}" src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js" integrity="sha512-h9644v03pHqrIHThkvXhB2PJ8zf5E9IyVnrSfZg8Yj8k4RsO4zldcQc4Bi9iVLUCCsqNY0b4WXVV4UB+wbWENA==" crossorigin="anonymous"></script>
        <script defer nonce="{{ base64_encode(random_bytes(16)) }}" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js" integrity="sha512-Y51n9mtKTVBh3Jbx5pZSJNDDMyY+yGe77DGtBPzRlgsf/YLCh13kSZ3JmfHGzYFCmOndraf0sQgfM654b7dJ3w==" crossorigin="anonymous"></script>
        <script defer nonce="{{ base64_encode(random_bytes(16)) }}" src="https://cdn.jsdelivr.net/npm/crypto-js/index.min.js" integrity="sha512-wAL/CX2oapYVhCeLcpIcdxZJjaVJxLl+XhMXV0ZuD7ZIq4WjjhQ3ZHhC4LWmDny3E9n3Cj6BEpVsuoqAeTmdYQ==" crossorigin="anonymous"></script>
        <script defer nonce="{{ base64_encode(random_bytes(16)) }}" src="https://cdn.jsdelivr.net/npm/dompurify/dist/purify.min.js" integrity="sha512-YlctBG9PGZIhh9keoqI3eZkQM9T8QUbiBi7qNYAO/TUEo8jqWX5pLp5+x1cKRQDRzJ/lyGyJ9WUVNIRduxIIFw==" crossorigin="anonymous"></script>
        <script defer nonce="{{ base64_encode(random_bytes(16)) }}" src="https://cdn.jsdelivr.net/npm/js-cookie/dist/js.cookie.min.js" integrity="sha512-nlp9/l96/EpjYBx7EP7pGASVXNe80hGhYAUrjeXnu/fyF5Py0/RXav4BBNs7n5Hx1WFhOEOWSAVjGeC3oKxDVQ==" crossorigin="anonymous"></script>
        <script defer nonce="{{ base64_encode(random_bytes(16)) }}" src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous"></script>
        <script defer nonce="{{ base64_encode(random_bytes(16)) }}" src="https://cdn.jsdelivr.net/npm/sweetalert2" integrity="sha512-rBcqrtFFt2PxFGp3ffb/lECz3pYr2DoF1FWmnMLy6qVdAOnaQg2C4wK84m64K36aK0qxkImFrlb/AKgOoeTvSg==" crossorigin="anonymous"></script>
        <script defer nonce="{{ base64_encode(random_bytes(16)) }}" src="https://cdn.jsdelivr.net/npm/validator/validator.min.js" integrity="sha512-D1UQZu1TzZtC8ZwtjDngmaTnXcPXKRdgWSqLxfsW9eY3kWcJV8AN0BP+taOmhyoOJe4io2BjkvSrskYZ2OSQ8A==" crossorigin="anonymous"></script>
        <script defer nonce="{{ base64_encode(random_bytes(16)) }}" type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" integrity="sha512-EyvpeiXzWi5LEZNtV9VN1TEbN0k4QgVJvxz/rM/0h66lz3Z/zD3JGdeL9xO0+bF3pwX0kOxwA4apAxVaFMUuLA==" crossorigin="anonymous"></script>
        <script defer nonce="{{ base64_encode(random_bytes(16)) }}" nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" integrity="sha512-I/fJS7jWAgGu7A3wEgtWU3C+Pu0N/wSyy0nWkf53JtB3MhX9hXW3rDL9TdX07mepq+vFv5cdHqGW6Kgl8ix68Q==" crossorigin="anonymous"></script>
    </body>

    @if(env('APP_ENV') === 'production')
        {{-- <script nonce="{{ base64_encode(random_bytes(16)) }}">
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js')
                .then(() => console.log("✅ Service Worker registered"))
                .catch(err => console.log("❌ SW failed:", err));
        } else {
            console.warning("⚠ Service Worker tidak didukung browser ini.");
        }

        (function() {
            // ✅ Daftar pengecekan fitur
            const hasSW = 'serviceWorker' in navigator;
            const hasLocalStorage = typeof window.localStorage !== "undefined";
            const hasFetch = typeof window.fetch === "function" && typeof Promise !== "undefined";

            // ✅ Registrasi Service Worker untuk browser modern
            if (hasSW) {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(() => console.log("✅ Service Worker registered"))
                    .catch(err => console.log("❌ SW failed:", err));
            } else {
                console.log("⚠ Service Worker tidak didukung browser ini.");
            }

            // ✅ Fallback caching untuk browser lama
            if (!hasLocalStorage) {
                console.log("⚠ localStorage tidak tersedia.");
                return;
            }

            // ✅ Fungsi Fetch dengan fallback
            function fetchWithFallback(url, callback) {
                // Ambil cache dari localStorage jika ada
                try {
                    const cached = localStorage.getItem(url);
                    if (cached) {
                        callback(JSON.parse(cached));
                    }
                } catch (err) {
                    console.warn("⚠ Gagal parsing cache:", err);
                }

                // Jika browser support fetch, gunakan fetch
                if (hasFetch) {
                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            try {
                                localStorage.setItem(url, JSON.stringify(data));
                            } catch (err) {
                                console.warn("⚠ localStorage penuh atau error:", err);
                            }
                            callback(data);
                        })
                        .catch(err => console.log("Fetch error:", err));
                } else {
                    // Jika tidak ada fetch (browser super lawas), fallback ke XHR
                    console.log("⚠ fetch tidak ada, fallback ke XMLHttpRequest.");
                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", url, true);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            try {
                                var data = JSON.parse(xhr.responseText);
                                localStorage.setItem(url, JSON.stringify(data));
                                callback(data);
                            } catch (err) {
                                console.warn("⚠ Gagal simpan data dari XHR:", err);
                            }
                        }
                    };
                    xhr.send();
                }
            }

            // ✅ Contoh pemakaian
            fetchWithFallback("/api/posts", function(data) {
                console.log("Posts loaded:", data);
            });

        })();
        </script> --}}
    @endif
</html>
