<?php
use App\Libraries\myfunction as fun;
$bodyColor = fun::getRawCookie('theme');
$textColor = fun::getRawCookie('textColorRGB');
?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        <meta charSet="utf-8" />
        <meta name="description" content="Syafiq Psikotest Online App, adalah aplikasi psikotest berbasis online web, dimana dapat diakses di perangkat manapun." />
        <meta property="og:description" content="Syafiq Psikotest Online App, adalah aplikasi psikotest berbasis online web, dimana dapat diakses di perangkat manapun." />
        <meta name="keywords" content="Syafiq, PT. Solusi, Syafiq Psikotest, PHP, Laravel, Javascript, React.JS, MUI.JS, Material UI, Tailwind CSS" />
        <meta name="author" content="Syafiq. Syahri Ramadhan Wiraasmara (ARI)" />
        <meta name="publisher" content="Syafiq. Syahri Ramadhan Wiraasmara (ARI)" />
        <meta name="developer" content="Syahri Ramadhan Wiraasmara (ARI)" />
        <link rel="author" href="https://github.com/ariwiraasmara" />
        <link rel="repository" href="https://github.com/ariwiraasmara/syafiq_psikotest_frontend_nextjs" />
        <link rel="license" href="https://github.com/ariwiraasmara/syafiq_psikotest_frontend_nextjs?tab=AGPL-3.0-1-ov-file#" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:type" content="application, website" />
        <meta property="og:locale" content="id_ID" />
        <meta name="theme-color" content={theme} />

        {{-- Nanti url href diubah dan disesuaikan --}}
        <link rel="icon" href="/favicon.ico?favicon.45db1c09.ico" sizes="256x256" type="image/x-icon" />
        <link rel="apple-touch-icon" href="/favicon.ico?favicon.45db1c09.ico" />
        <link rel="apple-touch-icon-precomposed" sizes="180x180" href="/favicon.ico?favicon.45db1c09.ico" />
        <meta property="og:image" content="/favicon.ico?favicon.45db1c09.ico" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <style>
            :root {
                --background: #ffffff;
                --foreground: #171717;
            }

            @media (prefers-color-scheme: dark) {
            :root {
                --background: {{ $bodyColor }};
                --foreground: #ededed;
            }
            }

            body {
                color: var(--foreground);
                background: var(--background);
                font-family: Arial, Helvetica, sans-serif;
            }
        </style>

        <!-- Scripts -->
        @routes
        @viteReactRefresh
        @vite(['resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
