{{--
! Copyright @
! PT. Solusi Psikologi Banten
! Syafiq Marzuki
! Syahri Ramadhan Wiraasmara (ARI)
--}}
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

    <div class="p-4 text-black" style="margin-bottom: 100px;">
        <h1 class='hidden'>Halaman {{ $appbar_title }} | Admin</h1>
        @foreach($psikotest as $data)
            <a href="{{ route('admin_psikotest_'.$data) }}" rel="follow" title="{{ 'Psikotest '.$data }}" >
                <div class="bg-slate-50 border-b-2 p-2 rounded-md mt-2 text-black border-black shadow-xl">
                    <h2>{{ ucfirst($data) }}</h2>
                </div>
            </a>
        @endforeach
    </div>

    @if($roles > 1)
        @component('components.admin.navigasibawah', ['navval' => $navval, 'roles'=>$roles]) @endcomponent
    @endif
    @if($roles == 1)
    @component('components.admin.menusidebar', ['navval' => $navval, 'email' => $email, 'roles' => $roles]) @endcomponent
    @endif
    @component('components.footer', ['hidden' => 'hidden', 'otherCSS' => '']) @endcomponent
@endsection