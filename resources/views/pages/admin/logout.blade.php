{{--
! Copyright @
! PT. Solusi Psikologi Banten
! Syafiq Marzuki
! Syahri Ramadhan Wiraasmara (ARI)
--}}
@extends('layouts.app')
@section('content')
    <div class="grid grid-rows-[20px_1fr_20px] items-center justify-items-center min-h-screen p-8 pb-20 gap-16 sm:p-20 font-[family-name:var(--font-geist-sans)]" >
        <div class="flex flex-col gap-8 row-start-2 items-center sm:items-start">
            <div class="p-3 text-center justify-items-center mb-6">
                <div class="loader mt-6"></div>
            </div>
        </div>
    </div>

    @component('components.footer', ['hidden' => 'hidden', 'otherCSS' => '']) @endcomponent
@endsection