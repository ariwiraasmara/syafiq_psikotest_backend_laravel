<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        {{-- <title inertia>{{ config('app.name', 'Laravel') }}</title> --}}
        {!! meta()->toHtml() !!}
        <meta charSet="utf-8"/>
        <meta name="description" content="Syafiq Psikotest Online App, adalah aplikasi psikotest berbasis online web, dimana dapat diakses di perangkat manapun." />
        <meta property="og:description" content="Syafiq Psikotest Online App, adalah aplikasi psikotest berbasis online web, dimana dapat diakses di perangkat manapun." />
        <meta name="keywords" content="Syafiq, PT. Solusi, Syafiq Psikotest, PHP, Laravel, JavaScript, TypeScript, React.JS, MUI.JS." />
        <meta name="author" content="Syafiq. Syahri Ramadhan Wiraasmara (ARI)" />
        <meta name="publisher" content="Syafiq. Syahri Ramadhan Wiraasmara (ARI)" />
        <meta name="developer" content="Syahri Ramadhan Wiraasmara (ARI)" />
        <meta name="copyright" content="Syafiq. Syahri Ramadhan Wiraasmara (ARI). Year: {{ date('Y') }}" />
        <link rel="author" href="https://github.com/ariwiraasmara" />
        <link rel="repository" href="https://github.com/ariwiraasmara/syafiq_psikotest_backend_laravel" />
        <link rel="license" href="https://github.com/ariwiraasmara/syafiq_psikotest_backend_laravel?tab=AGPL-3.0-1-ov-file#" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
        <meta property="og:type" content="application, website" />
        <meta property="og:locale" content="id_ID" />
        <meta name="theme-color" content="rgba(200, 200, 255, 0.9)" />

        {{-- Nanti url href diubah dan disesuaikan --}}
        <link rel="icon" href="/favicon.ico?favicon.45db1c09.ico" sizes="256x256" type="image/x-icon" />
        <link rel="apple-touch-icon" href="/favicon.ico?favicon.45db1c09.ico" />
        <link rel="apple-touch-icon-precomposed" sizes="180x180" href="/favicon.ico?favicon.45db1c09.ico" />
        <meta property="og:image" content="/favicon.ico?favicon.45db1c09.ico" />

        <link rel="stylesheet" href="{{ asset('/css/additional.css') }}" />

        <!-- Scripts -->
        @routes
        @viteReactRefresh
        @vite(['resources/js/app.tsx', "resources/js/Pages/{$page['component']}.tsx"])
        @inertiaHead
    </head>
    <body class="antialiased">
        @inertia

        <footer class="hidden">
            <h2 class='font-bold'>Copyright @ {{ date('Y') }} : </h2>
            <h3 class='mt-2'>
                <address><strong>Syafiq (syafiq@gmail.com, +6285311487755)</strong></address>
            </h3>
            <h3 class='mt-2'>
                <address><strong>Syahri Ramadhan Wiraasmara (ariwiraasmara.sc37@gmail.com, +628176896353)</strong></address>
            </h3>
        </footer>
    </body>
</html>
