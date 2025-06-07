@php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
@endphp
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charSet="utf-8" />
        <title>{{ $title }}</title>
        <meta property="og:title" content="{{ $title }}" />
        <meta name="description" content="Syafiq Psikotest Online App, adalah aplikasi psikotest berbasis online web, dimana dapat diakses di perangkat manapun." />
        <meta property="og:description" content="Syafiq Psikotest Online App, adalah aplikasi psikotest berbasis online web, dimana dapat diakses di perangkat manapun." />
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
        <link rel="icon" href="/favicon.ico?favicon.45db1c09.ico" sizes="256x256" type="image/x-icon" />
        <link rel="apple-touch-icon" href="/favicon.ico?favicon.45db1c09.ico" />
        <link rel="apple-touch-icon-precomposed" sizes="180x180" href="/favicon.ico?favicon.45db1c09.ico" />
        <meta property="og:image" content="/favicon.ico?favicon.45db1c09.ico" />

        @if($onetime)
        <meta name="XSRF-TOKEN" content="{{ csrf_token() }}" />
        <meta name="__unique__" content="{{ $unique }}" />
        @endif

        <link rel="stylesheet" href="{{ asset('/css/additional.css') }}">
        <link rel="stylesheet" href="{{ tailwindcss('css/app.css') }}">
        
    </head>
    <body class="">
        <nav aria-label="breadcrumb" id="nav-breadcrumb" class="font-bold bg-black {{ $is_breadcrumb_hidden; }}">
            <span id="breadcrumb" className="mr-4 ml-4 font-bold">{{ $breadcrumb; }}</span>
        </nav>
        @yield('content')

        <script type="module" src="{{ asset('/js/myfunction.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/cryptojs@2.5.3/lib/Crypto.min.js"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/dompurify/dist/purify.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/js-cookie/dist/js.cookie.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>
        <script src="https://cdn.jsdelivr.net/npm/validator/validator.min.js"></script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </body>
</html>
