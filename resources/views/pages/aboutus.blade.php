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

    <div class="p-4 bg-aboutus">
        <div class="p-4 bg-lp-white-glasses">
            <h2 class="text-center text-2xl font-bold underline">Mengenai Kami</h2>
            <div class="mt-4 md:flex md:flex-row">
                <div class="md:mb-2">
                    <div class="p-2 mb-4 justify-items-center items-center">
                        <img src="{{ asset('images/Syafiq Marzuki.png') }}" class="border-2 border-black rounded-full shadow-xl" title="Syafiq Marzuki, Psikolog" alt="Syafiq Marzuki, Psikolog" />
                    </div>
                    <div class="p-2 mb-4 justify-items-center items-center">
                        <img src="{{ asset('images/HPI.jpg') }}" class="border-2 border-black shadow-xl" width="200" height="350" title="HPI" alt="HPI" />
                    </div>
                </div>
                <div class="md:p-4">
                    <p class="mt-4">{!! $data[0] !!}</p>
                    <p class="mt-4">{!! $data[1] !!}</p>
                    <p class="mt-4">{!! $data[2] !!}</p>
                    <p class="mt-4">{!! $data[3] !!}</p>
                </div>
            </div>
        </div>
    </div>

    @component('components.footer', ['hidden' => '', 'otherCSS' => '']) @endcomponent
@endsection
