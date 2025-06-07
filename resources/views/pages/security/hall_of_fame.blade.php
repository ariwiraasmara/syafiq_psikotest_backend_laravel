{{--
! Copyright @
! Syafiq
! Syahri Ramadhan Wiraasmara (ARI)
--}}
@extends('layouts.app')
@section('content')
    @component('components.appbarku', [
        'nama'         => '',
        'link_back'    => null,
        'appbar_title' => $appbar_title,
    ]) @endcomponent

    <div class="p-4 text-black" style="">
        <p>Kami ingin mengucapkan terima kasih kepada para peneliti berikut yang sudah membantu kami:</p>
    </div>

    @component('components.footer', ['hidden' => '', 'otherCSS' => '']) @endcomponent
@endsection