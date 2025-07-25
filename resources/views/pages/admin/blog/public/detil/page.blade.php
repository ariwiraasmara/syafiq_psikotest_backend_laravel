@php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
    use App\Libraries\myfunction;
@endphp
@extends('layouts.app')

@section('content')
    @component('components.appbarku', [
        'nama'         => '',
        'sidebar'      => false,
        'link_back'    => route('blog'),
        'appbar_title' => $appbar_title,
        'roles'        => 0
    ]) @endcomponent

    <div class="p-4" style="margin-bottom: 75px;">
        <h1 class="text-2lg font-bold hidden">{{ $data['title'] }}</h1>
        
        
        <div class="p-4 bg-white text-black rounded-lg shadow-xl">
            <p class="">{!! $data['content'] !!}</p>
            
            <div class="mt-2 text-sm border-t-2 border-gray-500">
                <h2 class="">Kategori: <a href="{{ route('blog').'?kategori='.$data['category'] }}" class="text-blue-800 hover:text-blue-500">{{ $data['category']; }}</a></h2>
                <h2 class="">Penulis: {{ $data['name']; }}</h2>
                <h3>Dibuat pada: {{ myfunction::formatTimestamp($data['created_at']) }}</h3>
    
                @if(($data['updated_at'] != '') || ($data['updated_at'] != null))
                    <h3 class="italic underline">Informasi ini telah diperbaharui pada: {{ myfunction::formatTimestamp($data['created_at']) }}</h3>
                @endif
            </div>
        </div>
    </div>

    @component('components.footer', ['hidden' => '', 'otherCSS' => 'bottom-0 w-full fixed']) @endcomponent
@endsection