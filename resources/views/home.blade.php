@php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
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
