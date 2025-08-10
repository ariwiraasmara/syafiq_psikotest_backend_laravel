@php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
@endphp
@php
    $style_content = 'margin-bottom: 0px;';
    if($roles > 1) {
        $style_content = 'margin-bottom: 100px;';
    }
@endphp
@extends('layouts.app')
@section('content')
    @component('components.appbarku', [
        'nama'         => $nama,
        'email'        => $email,
        'sidebar'      => true,
        'link_back'    => null,
        'appbar_title' => $appbar_title,
        'roles'        => $roles
    ]) @endcomponent

    <div class="p-4 text-black" style="{{ $style_content; }}">
        <div>
            <h2 class="hidden">Halaman {{ $appbar_title }} | Admin</h2>
            <h3 class="text-xl font-bold">Selamat Datang, {{ $nama }}</h3>
        </div>

        <div class="mt-4">
            <h3 class="font-bold">Daftar 10 Peserta Tes Psikotest Terbaru</h3>
            @component('components.admin.listpeserta', [
                'listpeserta' => $data,
                'islatest'    => true
            ]) @endcomponent
        </div>
    </div>

    @if($roles > 1)
        @component('components.admin.navigasibawah', ['navval' => $navval, 'roles'=>$roles]) @endcomponent
    @endif
    @if($roles == 1)
        @component('components.admin.menusidebar', ['navval' => $navval, 'email' => $email, 'roles' => $roles]) @endcomponent
    @endif
    @component('components.footer', ['hidden' => 'hidden', 'otherCSS' => '']) @endcomponent
@endsection