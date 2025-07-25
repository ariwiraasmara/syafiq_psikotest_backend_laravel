{{--
! Copyright @
! PT. Solusi Psikologi Banten
! Syafiq Marzuki
! Syahri Ramadhan Wiraasmara (ARI)
--}}
@php
    use App\Libraries\myfunction;

    $style_content = 'margin-bottom: 50px;';
    $style_paging = 'bottom: 1px; margin-bottom: 0px; padding: 10px;';

    if($roles > 1) {
        $style_content = 'margin-bottom: 120px;';
        $style_paging = 'bottom: 1px; margin-bottom: 61px; padding: 10px;';
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
        'roles'        => $roles,
        'navval'       => $navval,
        'email' => $email
    ]) @endcomponent

    <div class="p-4 text-black" style="{{ $style_content; }}">
        <h1 class='hidden'>Halaman {{ $appbar_title }} | Admin</h1>
        <div class="p-2 mx-auto flex justify-between items-center w-full">
            <div class="w-full">
                <button type="button" id="btn-refresh" class="rounded-lg text-white w-full shadow-xl" style="padding: 5px; background-color: #0a0;" onclick="refresh()">
                    <ion-icon name="refresh-outline"></ion-icon>
                </button>
            </div>
            <div class="w-full">
                <button type="button" id="btn-togglesearch" class="rounded-lg text-white w-full shadow-xl" onclick="toggleSearch()" style="padding: 5px; background-color: #55f;">
                    <ion-icon name="search-outline"></ion-icon>
                </button>
            </div>
            <div class="w-full">
                <select id="select-sort" title="Pilih Berdasarkan..." class="rounded-lg bg-white w-full shadow-xl" style="padding: 5px;" onchange="sortChange();">
                    <option value="" disabled>Pilih Berdasarkan...</option>
                    <option value="variabel" @if($sort == 'variabel') selected @endif >Nama Variabel</option>
                    <option value="values" @if($sort == 'values') selected @endif >Nilai Variabel</option>
                </select>
            </div>
            <div class="w-full">
                <select id="select-by" title="Urutkan Berdasarkan..." class="rounded-lg bg-white w-full shadow-xl" style="padding: 5px;" onchange="byChange();">
                    <option value="" disabled>Urutkan Berdasarkan...</option>
                    <option value="asc" @if($by == 'asc') selected @endif>A - Z</option>
                    <option value="desc" @if($by == 'desc') selected @endif>Z - A</option>
                </select>
            </div>
        </div>
        <div id="searchArea" class="mt-2 p-2 flex hidden">
            <div class="w-80 flex-1">
                <input type="text" id="txt-search" placeholder="Cari..." class="bg-white rounded-lg p-2 w-full shadow-xl" value="{{ $search }}" />
            </div>
            <div class="w-20 flex-1">
                <button type="button" id="btn-search" class="text-white rounded-lg w-full shadow-xl" onclick="search()" style="background-color: #0a0; padding: 8px;">Cari</button>
            </div>
        </div>
        <div style="margin-top: 30px">
            <div id="data-container">
                @component('components.admin.listpeserta', [
                    'listpeserta' => $data,
                    'islatest'    => false
                ]) @endcomponent
            </div>
        </div>
    </div>

    <div class="text-center fixed w-full bg-black text-white" style="{{ $style_paging; }}">
        <span class='mr-2'>Halaman </span>
        <select id="select-page" class="border-2 border-white bg-white rounded-md text-black text-right" onchange="pageChange()" style="width 80px; height: 30px;">
            @for($x = 1; $x <= $lastpage; $x++)
                <option value="{{ $x }}" @if($x == $page) selected @endif>{{ $x }}</option>
            @endfor
        </select>
        <span class='ml-2'>/ {{ $lastpage }}</span>
    </div>

    @if($roles > 1)
        @component('components.admin.navigasibawah', ['navval' => $navval, 'roles'=>$roles]) @endcomponent
    @endif
    @if($roles == 1)
        @component('components.admin.menusidebar', ['navval' => $navval, 'email' => $email, 'roles' => $roles]) @endcomponent
    @endif
    @component('components.footer', ['hidden' => 'hidden', 'otherCSS' => '']) @endcomponent

    <script>
        let data = null;
        let currentpage = 1;
        let lastpage = 1;

        function toggleSearch() {
            if(document.getElementById('searchArea').classList.toggle('hidden')) {
                document.getElementById('btn-togglesearch').innerHTML = '<ion-icon name="search-outline"></ion-icon>';
            }
            else {
                document.getElementById('btn-togglesearch').innerHTML = '<ion-icon name="close-outline"></ion-icon>';
            }
        }

        function refresh() {
            window.location.href= `{{ route('admin_peserta', ['sort' => 'nama', 'by' => 'asc', 'search' => '-']) }}?page=1`;
        }

        function sortChange() {
            const sort = document.getElementById('select-sort').value;
            const by = document.getElementById('select-by').value;
            let search = document.getElementById('txt-search').value;
            if(search == null || search == '') search = '-';
            window.location.href= `/public/admin/peserta/${sort}/${by}/${search}?page={{ $page }}`;
        }

        function byChange() {
            const sort = document.getElementById('select-sort').value;
            const by = document.getElementById('select-by').value;
            let search = document.getElementById('txt-search').value;
            if(search == null || search == '') search = '-';
            window.location.href= `/public/admin/peserta/${sort}/${by}/${search}?page={{ $page }}`;
        }

        function search() {
            const sort = document.getElementById('select-sort').value;
            const by = document.getElementById('select-by').value;
            let search = document.getElementById('txt-search').value;
            if(search == null || search == '') search = '-';
            window.location.href= `/public/admin/peserta/${sort}/${by}/${search}?page=1`;
        }
        
        function pageChange() {
            const page = document.getElementById('select-page').value;
            const sort = document.getElementById('select-sort').value;
            const by = document.getElementById('select-by').value;
            let search = document.getElementById('txt-search').value;
            if(search == null || search == '') search = '-';
            window.location.href= `/public/admin/peserta/${sort}/${by}/${search}?page=${page}`;
        }
    </script>
@endsection