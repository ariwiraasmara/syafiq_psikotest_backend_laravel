@php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
    use App\Libraries\myfunction;
@endphp
@extends('layouts.app')

@section('content')
    @component('components.homepage.header') @endcomponent
    @component('components.homepage.navbar', [
        'ispeserta' => false,
        'path'      => $path,
        'domain'    => $domain,
    ]) @endcomponent

    @if(($data == null) || ($data == ''))
        <div class="text-center p-8">
            <h2 class="text-2xl font-bold">Tidak ada berita</h2>
        </div>
    @else
        <div class="text-center p-2">
            <h2 class="text-2xl font-bold">Acara, Artikel, Informasi, Kegiatan</h2>
        </div>
        <div class="mt-2 p-2">
            <form action="" method="GET">
                @csrf
                <input type="hidden" name="_unique" id="_unique" value="{{ $unique; }}" />
                <div class="flex flex-row flex-wrap w-full shadow-xl">
                    <div class="basis-4/4 w-full">
                        <span style="background-color: #1d4ed8; color: #fff; padding: 5px; margin-bottom: -3px;">Cari Informasi Di Website Ini...</span>
                    </div>
                    <div class="basis-3/4 w-full">
                        <input type="text" name="cari" class="w-full bg-white" style="height: 45px; padding: 10px; border: 2px solid #1d4ed8" />
                    </div>
                    <div class="basis-1/4 ">
                        <button type="submit" class="text-white w-full" style="height: 45px; padding: 10px; background-color: #1d4ed8">
                            <ion-icon name="search-outline"></ion-icon>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="mt-4 p-2 grid max-lg:grid-cols-2 md:max-2xl:grid-cols-3 gap-2" style="margin-bottom: 0px;">
            @forelse($data as $item)
                <a href="{{ route('blog_detail', ['judul' => $item['title']]) }}" class="bg-white p-4 mx-4 mb-4 shadow-xl" rel="follow" title="{{ $item['title']; }}" style="margin-left: 5px; margin-right: 5px;">
                    <h2 class="text-xl font-bold mb-2">{{ $item['title']; }}</h2>
                    <p class="text-black">{{ substr($item['content'], 0, 100).'.....' }}</p>
                    <div class="mt-2 border-t-2 border-black text-xs">
                        <h3 class="font-bold">Kategori: {{ $item['category']; }}</h3>
                        <h3 class="font-bold">Penulis: {{ $item['name']; }}</h3>
                        <h3 class="italic">Dibuat: {{ myfunction::formatTimestamp($item['created_at']); }}</h3>
                    </div>
                </a>
            @empty
                <div class="text-center">
                    Data Kosong
                </div>
            @endforelse
        </div>
        <div class="paging-area">
            <span class='mr-2'>Halaman </span>
            <select id="select-page" class="border-2 border-white bg-white rounded-md text-black text-right" onchange="pageChange()" style="width 80px; height: 30px;">
                @for($x = 1; $x <= $lastpage; $x++)
                    <option value="{{ $x }}" @if($x == $page) selected @endif>{{ $x }}</option>
                @endfor
            </select>
            <span class='ml-2'>/ {{ $lastpage }}</span>
        </div>
    @endif

    @component('components.footer', ['hidden' => '', 'otherCSS' => 'w-full']) @endcomponent

    <script>
        let data = null;
        let currentpage = 1;
        let lastpage = 1;

        function pageChange() {
            const page = document.getElementById('select-page').value;
            window.location.href= `{{$link_page_change}}${page}`;
        }
    </script>
@endsection