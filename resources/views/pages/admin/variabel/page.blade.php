@php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
    use App\Libraries\myfunction;
    $page = @$_GET['page'];
@endphp
@extends('layouts.app')
@section('content')
    @component('components.appbarku', [
        'nama'         => $nama,
        'link_back'    => null,
        'appbar_title' => $appbar_title,
    ]) @endcomponent

    <div class="p-4 text-black" style="margin-bottom: 130px;">
        <h1 class='hidden'>Halaman {{ $appbar_title }} | Admin</h1>
        <div class="p-2 text-right">
            <button type="button" id="btn-refresh" class="rounded-lg btn-sm text-white" style="width: 75px; background-color: #0a0;" onclick="refresh()">
                <ion-icon name="refresh-outline"></ion-icon>
            </button>
            <button type="button" id="btn-togglesearch" class="rounded-lg btn-sm text-white" onclick="toggleSearch()" style="width: 75px; background-color: #55f;">
                <ion-icon name="search-outline"></ion-icon>
            </button>
            <select id="select-sort" title="Pilih Berdasarkan..." class="rounded-lg border-2 border-black bg-white" style="width: 50px; height: 30px;" onchange="sortChange();">
                <option value="" disabled>Pilih Berdasarkan...</option>
                <option value="variabel" @if($sort == 'variabel') selected @endif >Nama Variabel</option>
                <option value="values" @if($sort == 'values') selected @endif >Nilai Variabel</option>
            </select>
            <select id="select-by" title="Urutkan Berdasarkan..." class="rounded-lg border-2 border-black bg-white" style="width: 50px; height: 30px;" onchange="byChange();">
                <option value="" disabled>Urutkan Berdasarkan...</option>
                <option value="asc" @if($by == 'asc') selected @endif>A - Z</option>
                <option value="desc" @if($by == 'desc') selected @endif>Z - A</option>
            </select>
        </div>
        <div id="searchArea" class="mt-2 p-2 flex hidden">
            <div class="w-80 flex-1">
                <input type="text" id="txt-search" placeholder="Cari..." class="bg-white border-2 border-black rounded-lg p-2 w-full" value="{{ $search }}" />
            </div>
            <div class="w-20 flex-1">
                <button type="button" id="btn-search" class="text-white border-2 border-black rounded-lg w-full" onclick="search()" style="background-color: #0a0; padding: 8px;">Cari</button>
            </div>
        </div>
        <div style="margin-top: 30px">
            <div id="data-container">
                @foreach($data as $data)
                    <div class="bg-slate-50 border-b-2 p-3 rounded-t-md mt-2 border-black">
                        <div class="static">
                            <div>
                                <span>
                                    {{ $data['variabel'].' = '.$data['values'] }}
                                </span>
                            </div>
                            <div class="text-right" style="margin-top: -23px;">
                                <a href="{{ route('admin_variabel_edit', ['id' => myfunction::enval($data['id'], true)]); }}" rel="nofollow" style="margin-right: 15px;">
                                    <ion-icon name="pencil-outline"></ion-icon>
                                    <span class="hidden">Edit</span>
                                </a>
                                <span onclick="fDelete('{{ myfunction::enval($data['id'], true); }}', '{{ $data['variabel']; }}', '{{ $data['values']; }}')">
                                    <ion-icon name="trash-outline"></ion-icon>
                                    <span class="hidden">Delete</span>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <button type="button" class="fab bg-blue-700" style="margin-bottom: 90px;" onclick="window.location.href = '{{ route('admin_variabel_baru') }}'">
            <a href="#" rel="nofollow" title="Variabel Baru">
                +
            </a>
        </button>
    </div>

    <div class="text-center fixed w-full bg-black text-white" style="bottom: 1px; margin-bottom: 70px; padding: 10px;">
        <span class='mr-2'>Halaman </span>
        <select id="select-page" class="border-2 border-white bg-white rounded-md text-black text-right" onchange="pageChange()" style="width 80px; height: 30px;">
            @for($x = 1; $x <= $lastpage; $x++)
                <option value="{{ $x }}" @if($x == $page) selected @endif>{{ $x }}</option>
            @endfor
        </select>
        <span class='ml-2'>/ {{ $lastpage }}</span>
    </div>

    @component('components.admin.navigasibawah', ['navval' => $navval]) @endcomponent
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

        async function fDelete(id, nvariabel, nvalues) {
            if(validator.isBase64(id)) {
                Swal.fire({
                    title: "Anda yakin ingin menghapus data variabel ini?",
                    html: `<b>${nvariabel}</b> = <b>${nvalues}</b>`,
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Ya",
                    cancelButtonText: "Batalkan",
                    icon: "warning",
                    showLoaderOnConfirm: true,
                    preConfirm: async () => {
                        try {
                            axios.defaults.withCredentials = true;
                            axios.defaults.withXSRFToken = true;
                            const csrfToken = await axios.get(`/sanctum/csrf-cookie`);
                            const response = await axios.delete(`/public/admin/variabel-delete/${id}`, {
                                withCredentials: true,
                                headers: {
                                    'Content-Type': 'application/json',
                                    'XSRF-TOKEN': csrfToken,
                                    'tokenlogin': '{{ $unique; }}',
                                }
                            });
                            if(response.data.success) {
                                setTimeout(() => {
                                    refresh();
                                }, 1000);
                            }
                        } catch (error) {
                            console.info('Terjadi Error AdminVariabel-fDelte:', error)
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Terhapus!",
                            text: "Data Telah Berhasil Dihapus",
                            icon: "success"
                        });
                    }
                });
            }
            else {
                alert('Invalid Credentials!');
            }
        }

        function refresh() {
            window.location.href= `{{ route('admin_variabel_setting', ['sort' => 'variabel', 'by' => 'asc', 'search' => '-']) }}?page=1`;
        }

        function sortChange() {
            const sort = document.getElementById('select-sort').value;
            const by = document.getElementById('select-by').value;
            let search = document.getElementById('txt-search').value;
            if(search == null || search == '') search = '-';
            window.location.href= `/public/admin/variabel-setting/${sort}/${by}/${search}?page={{ $page }}`;
        }

        function byChange() {
            const sort = document.getElementById('select-sort').value;
            const by = document.getElementById('select-by').value;
            let search = document.getElementById('txt-search').value;
            if(search == null || search == '') search = '-';
            window.location.href= `/public/admin/variabel-setting/${sort}/${by}/${search}?page={{ $page }}`;
        }

        function search() {
            const sort = document.getElementById('select-sort').value;
            const by = document.getElementById('select-by').value;
            let search = document.getElementById('txt-search').value;
            if(search == null || search == '') search = '-';
            window.location.href= `/public/admin/variabel-setting/${sort}/${by}/${search}?page=1`;
        }
        
        function pageChange() {
            const page = document.getElementById('select-page').value;
            const sort = document.getElementById('select-sort').value;
            const by = document.getElementById('select-by').value;
            let search = document.getElementById('txt-search').value;
            if(search == null || search == '') search = '-';
            window.location.href= `/public/admin/variabel-setting/${sort}/${by}/${search}?page=${page}`;
        }
    </script>
@endsection