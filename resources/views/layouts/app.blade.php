@php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
$nonce = request()->attributes->get('csp_nonce');
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
        <link rel="icon" href="{{ asset('images/logo1.png') }}" sizes="256x256" type="image/x-icon" />
        <link rel="apple-touch-icon" href="{{ asset('images/logo1.png') }}" />
        <link rel="apple-touch-icon-precomposed" sizes="180x180" href="{{ asset('images/logo1.png') }}" />
        <meta property="og:image" content="{{ asset('images/logo1.png') }}" />

        @if($onetime)
        <meta name="XSRF-TOKEN" content="{{ csrf_token() }}" />
        <meta name="X-UNIQUE" content="{{ $unique }}" />
        @endif

        <link rel="stylesheet" href="{{ asset('css/additional.css') }}" />
        <link rel="stylesheet" href="{{ tailwindcss('css/app.css') }}" />
        <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />
    </head>
    <body id="{{ 'app-'.env('APP_ENV').'-content' }}" class="">
        <nav aria-label="breadcrumb" id="nav-breadcrumb" class="font-bold bg-black {{ $is_breadcrumb_hidden; }}">
            <span id="breadcrumb" className="mr-4 ml-4 font-bold">{{ $breadcrumb; }}</span>
        </nav>
        @yield('content')

        <script defer nonce="{{ $nonce }}" type="module" src="{{ asset('js/myfunction.js') }}"></script>
        <script defer nonce="{{ $nonce }}" src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js" integrity="sha256-BA81LP1os6XfLCoGGW8QArXABI+U4VNDWvhormFxWOk=" crossorigin="anonymous"></script>
        <script defer nonce="{{ $nonce }}" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js" integrity="sha256-Lye89HGy1p3XhJT24hcvsoRw64Q4IOL5a7hdOflhjTA=" crossorigin="anonymous"></script>
        <script defer nonce="{{ $nonce }}" src="https://cdn.jsdelivr.net/npm/crypto-js/index.min.js" integrity="sha256-fbDSXoG1W4eJBx/hq3c7X6DpC+5Wx8Ndqj73DWYUZDo=" crossorigin="anonymous"></script>
        <script defer nonce="{{ $nonce }}" src="https://cdn.jsdelivr.net/npm/dompurify/dist/purify.min.js" integrity="sha256-ieH6dkfLSVNw06mXrOQ4f10V2fTFrxI1LFPapACVYoc=" crossorigin="anonymous"></script>
        <script defer nonce="{{ $nonce }}" src="https://cdn.jsdelivr.net/npm/js-cookie/dist/js.cookie.min.js" integrity="sha256-WCzAhd2P6gRJF9Hv3oOOd+hFJi/QJbv+Azn4CGB8gfY=" crossorigin="anonymous"></script>
        <script defer nonce="{{ $nonce }}" src="https://cdn.jsdelivr.net/npm/sweetalert2" integrity="sha256-Ua8fKA4E1l7RSqT5HOjK0m/PrSwP41XFTs++qmtWey8=" crossorigin="anonymous"></script>
        <script defer nonce="{{ $nonce }}" src="https://cdn.jsdelivr.net/npm/validator/validator.min.js" integrity="sha256-bpSr8wa+lfqpTs0vp5AQbrcMR2NZ3jTkPp3zcD5mhv0=" crossorigin="anonymous"></script>
        <script defer nonce="{{ $nonce }}" type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" integrity="sha256-Bi+gzul97kP90CUgTGd2rmCdcaVbYRexALy/at85S9I=" crossorigin="anonymous"></script>
        <script defer nonce="{{ $nonce }}" nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" integrity="sha256-rrxoBOddMUI9Hqg7AdXOPST4sFpIXm/13+baTHTexRE=" crossorigin="anonymous"></script>
    </body>

    @if(env('APP_ENV') === 'production')
    <script defer nonce="{{ $nonce }}">
		const swUrl = `/public/service-worker.js`;
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register(swUrl)
                .then(() => console.log("✅ Service Worker registered"))
                .catch(err => console.log("❌ SW failed:", err));
        } else {
            console.warning("⚠ Service Worker tidak didukung browser ini.");
        }

        (function() {
            const hasSW = 'serviceWorker' in navigator;
            const hasLocalStorage = typeof window.localStorage !== "undefined";
            const hasFetch = typeof window.fetch === "function" && typeof Promise !== "undefined";

            if (hasSW) {
                navigator.serviceWorker.register(swUrl)
									.then(() => console.log("✅ Service Worker registered"))
									.catch(err => console.log("❌ SW failed:", err));
            } else {
                console.log("⚠ Service Worker tidak didukung browser ini.");
            }

            if (!hasLocalStorage) {
                console.log("⚠ localStorage tidak tersedia.");
                return;
            }

            /*
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

            fetchWithFallback("/api/posts", function(data) {
                console.log("Posts loaded:", data);
            });
            */
        })();
    </script>
    @endif
</html>
