{{--
! Copyright @
! Syafiq
! Syahri Ramadhan Wiraasmara (ARI)
--}}
@extends('layouts.app')
@section('content')
    @component('components.appbarku', [
        'nama'         => $nama,
        'link_back'    => null,
        'appbar_title' => $appbar_title,
    ]) @endcomponent

    <div class="p-4 text-black" style="margin-bottom: 100px;">
        <div>
            <h1 class="hidden">Halaman {{ $appbar_title }} | Admin</h1>
            <h2 class="text-xl font-bold">Selamat Datang, {{ $nama }}</h2>
        </div>

        <div class="mt-4">
            <h2 class="font-bold">Daftar 10 Peserta Tes Psikotest Terbaru</h2>
            @component('components.admin.listpeserta', [
                'listpeserta' => $data,
                'islatest'    => true
            ]) @endcomponent
        </div>
    </div>

    @component('components.admin.navigasibawah', ['navval' => $navval]) @endcomponent
    @component('components.footer', ['hidden' => 'hidden', 'otherCSS' => '']) @endcomponent
@endsection