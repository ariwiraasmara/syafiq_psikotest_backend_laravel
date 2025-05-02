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
        <h1 class='hidden'>Halaman {{ $appbar_title }} | Admin</h1>
        @foreach($psikotest as $data)
            <a href="{{ route('admin_psikotest_'.$data) }}" rel="follow" title="{{ 'Psikotest '.$data }}" >
                <div class="bg-slate-50 border-b-2 p-2 rounded-md mt-2 text-black border-black">
                    <h2>{{ $data }}</h2>
                </div>
            </a>
        @endforeach
    </div>

    @component('components.admin.navigasibawah', ['navval' => $navval]) @endcomponent
    @component('components.footer', ['hidden' => 'hidden', 'otherCSS' => '']) @endcomponent
@endsection