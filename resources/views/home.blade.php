@php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
@endphp
@extends('layouts.app')
@section('content')
    @component('components.homepage.header') @endcomponent
    @component('components.homepage.navbar', [
        'ispeserta' => $ispeserta,
        'path'      => $path,
        'domain'    => $domain
    ]) @endcomponent
    @component('components.homepage.welcome', ['data_blog' => $data_blog]) @endcomponent
    @component('components.homepage.about') @endcomponent
    @component('components.footer', ['hidden' => '', 'otherCSS' => '']) @endcomponent
@endsection
