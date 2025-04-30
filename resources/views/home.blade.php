@php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
@endphp
@extends('layouts.app')
@section('content')
    @component('components.homepage.header') @endcomponent
    @component('components.homepage.navbar') @endcomponent
    @component('components.homepage.welcome') @endcomponent
    @component('components.homepage.about') @endcomponent
    @component('components.footer', ['hidden' => '', 'otherCSS' => '']) @endcomponent

    <script>
        Crypto = (require 'cryptojs').Crypto;
        const key = '123';
        const coba = 'Hello World';

        document.addEventListener('DOMContentLoaded', function () {
            eb = Crypto.DES.encrypt ub, key, {asBytes: true, mode: mode}
        });
    </script>
@endsection
