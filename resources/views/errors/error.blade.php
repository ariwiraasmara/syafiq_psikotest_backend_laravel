<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
$title = "Error!";
$pathURL = url()->current();
$robots = "index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate";
$is_breadcrumb_hidden = "hidden";
$breadcrumb ="/";
$onetime = false;
?>
@extends('layouts.app')
@section('content')
    <style>
        body {
            background-color: #000;
            color: #fff;
        }
    </style>

    <div class="grid grid-rows-[20px_1fr_20px] items-center justify-items-center min-h-screen p-8 pb-20 gap-16 sm:p-20 font-[family-name:var(--font-geist-sans)]" >
        <div class="flex flex-col gap-8 row-start-2 items-center sm:items-start">

            <h1 class="font-bold text-2xl text-center underline">Yang Pastinya Terjadi Eror Siih...<br/>Ga Tau Apa...<br/>DAN LU HARUS PEKA DISINI!!</h1>

        </div>
    </div>

    @component('components.footer', ['hidden' => '', 'otherCSS' => 'bottom-0 w-full']) @endcomponent
@endsection