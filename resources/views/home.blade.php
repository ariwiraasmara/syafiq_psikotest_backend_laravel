@php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
@endphp
@extends('layouts.app')
@section('content')
    @component('components.homepage.header') @endcomponent
    @component('components.homepage.navbar', ['ispeserta' => $ispeserta]) @endcomponent
    @component('components.homepage.welcome') @endcomponent
    @component('components.homepage.about') @endcomponent
    @component('components.footer', ['hidden' => '', 'otherCSS' => '']) @endcomponent
@endsection
