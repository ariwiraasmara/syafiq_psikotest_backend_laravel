@php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
use App\Libraries\myfunction;
use Illuminate\Support\Facades\URL;
$style_content = 'margin-bottom: 60px;';
$style_fab = 'margin-bottom: 23px;';
$style_paging = 'bottom: 1px; margin-bottom: 0px; padding: 10px;';
@endphp
@extends('layouts.app')
@section('content')
    @component('components.appbarku', [
        'nama'         => $nama,
        'email'        => $email,
        'sidebar'      => false,
        'link_back'    => route('admin_monitor_userlog_activities', ['sort' => 'Users.name', 'by' => 'asc', 'search' => '-', 'page' => 1]),
        'appbar_title' => $appbar_title,
        'roles'        => $roles,
        'navval'       => $navval,
        'email'        => $email
    ]) @endcomponent

    <div class="p-4 text-black" style="{{ $style_content; }}">
        @if($data)
            <div id="user-profile-summary">
                <p><span class="font-bold">Nama: </span> {{ $data['user'][0]['name'] }}</p>
                <p><span class="font-bold">Email: </span> {{ $data['user'][0]['email'] }}</p>

                @if($data['user'][0]['roles'] > 1)
                    <p><span class="font-bold">Roles: </span> Admin</p>
                @else
                    <p><span class="font-bold">Roles: </span> Super Admin</p>
                @endif
            </div>

            <div id="user-activities">
                @if($data['data'])
                    @if($type == 'user')
                        <div class="mt-4 mx-auto flex justify-between items-center w-full">
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
                                    <option value="id" @if($sort == 'id') selected @endif >ID</option>
                                    <option value="tanggal" @if($sort == 'tanggal') selected @endif >Tanggal</option>
                                    <option value="event" @if($sort == 'event') selected @endif >Event</option>
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

                        <div id="data-container" class="mt-0" style="width: 100%; overflow-x: scroll;">
                            <table class="bg-white text-black shadow-xl border-spacing-2 table-auto mt-6" style="width: 100%; overflow-x: scroll;">
                                <thead>
                                    <tr>
                                        <th class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">ID</th>
                                        <th class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">Tanggal</th>
                                        <th class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">IP Address</th>
                                        <th class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">Path</th>
                                        <th class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">URL</th>
                                        <th class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">Halaman</th>
                                        <th class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">Event</th>
                                        <th class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">Deskripsi</th>
                                        <th class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">Properties</th>
                                        <th class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">User Agent</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($data['data'] as $item)
                                        <tr>
                                            <td class="text-right" style="padding: 5px; border-left: 3px solid #000; border-right: 3px solid #000; border-bottom: 1px solid #ddd;">{{ $item['id'] }}</td>
                                            <td class="text-center" style="padding: 5px; border-right: 1px solid #eee; border-bottom: 1px solid #ddd;">{{ $item['tanggal'] }}</td>
                                            <td style="padding: 5px; border-right: 1px solid #eee; border-bottom: 1px solid #ddd;">{{ $item['ip_address'] }}</td>
                                            <td style="padding: 5px; border-right: 1px solid #eee; border-bottom: 1px solid #ddd;">{{ $item['path'] }}</td>
                                            <td style="padding: 5px; border-right: 1px solid #eee; border-bottom: 1px solid #ddd;">{{ $item['url'] }}</td>
                                            <td style="padding: 5px; border-right: 1px solid #eee; border-bottom: 1px solid #ddd;">{{ $item['page'] }}</td>
                                            <td style="padding: 5px; border-right: 1px solid #eee; border-bottom: 1px solid #ddd;">{{ $item['event'] }}</td>
                                            <td style="padding: 5px; border-right: 1px solid #eee; border-bottom: 1px solid #ddd;">{{ $item['deskripsi'] }}</td>
                                            <td style="padding: 5px; border-right: 1px solid #eee; border-bottom: 1px solid #ddd;">{{ $item['properties'] }}</td>
                                            <td class="" style="padding: 5px; border-right: 3px solid #000; border-bottom: 1px solid #aaa;">{{ $item['user_agent'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-2 mt-4 bg-white rounded-xl text-black shadow-xl">
                            <p style="border-bottom: 1px solid #eee;"><span class="font-bold">ID :</span> {{ $data['data'][0]['id'] }}</p>
                            <p style="border-bottom: 1px solid #eee;"><span class="font-bold">Tanggal :</span> {{ $data['data'][0]['tanggal'] }}</p>
                            <p style="border-bottom: 1px solid #eee;"><span class="font-bold">IP Address :</span> {{ $data['data'][0]['ip_address'] }}</p>
                            <p style="border-bottom: 1px solid #eee;"><span class="font-bold">Path :</span> {{ $data['data'][0]['path'] }}</p>
                            <p style="border-bottom: 1px solid #eee;"><span class="font-bold">URL :</span> {{ $data['data'][0]['url'] }}</p>
                            <p style="border-bottom: 1px solid #eee;"><span class="font-bold">Halaman :</span> {{ $data['data'][0]['page'] }}</p>
                            <p style="border-bottom: 1px solid #eee;"><span class="font-bold">Event :</span> {{ $data['data'][0]['event'] }}</p>
                            <p style="border-bottom: 1px solid #eee;"><span class="font-bold">Deskripsi :</span> {{ $data['data'][0]['deskripsi'] }}</p>
                            <p style="border-bottom: 1px solid #eee;"><span class="font-bold">Properties :</span> {{ $data['data'][0]['properties'] }}</p>
                            <p style="border-bottom: 1px solid #eee;"><span class="font-bold">User Agent :</span> {{ $data['data'][0]['user_agent'] }}</p>
                        </div>
                    @endif
                @else
                    <div class="p-4 mt-2 bg-white rounded-lg text-black shadow-xl">
                        <h3 class="font-bold text-center text-2xl">Data Aktifitas Kosong!</h3>
                    </div>
                @endif
            </div>

            <div class="flex flex-row">
                <div class="basis-1/2">
                    <button type="button" class="p-2 bg-blue-700 text-white shadow-xl w-full" onclick="backup()">Backup</button>
                </div>
                <div class="basis-1/2">
                    <button type="button" class="p-2 bg-red-700 text-white shadow-xl w-full" onclick="deleteAllActivities()">Hapus</button>
                </div>
            </div>
        @else
            <h3 class="font-bold text-center text-2xl">Data Kosong!</h3>
        @endif
    </div>

    @if($type == 'user')
        <div class="text-center fixed w-full bg-black text-white" style="{{ $style_paging; }}">
            <span class='mr-2'>Halaman </span>
            <select id="select-page" class="border-2 border-white bg-white rounded-md text-black text-right" onchange="pageChange()" style="width 80px; height: 30px;">
                @for($x = 1; $x <= $lastpage; $x++)
                    <option value="{{ $x }}" @if($x == $page) selected @endif>{{ $x }}</option>
                @endfor
            </select>
            <span class='ml-2'>/ {{ $lastpage }}</span>
        </div>
    @endif

    @if($roles == 1)
        @component('components.admin.menusidebar', ['navval' => $navval, 'email' => $email, 'roles' => $roles]) @endcomponent
    @endif
    @component('components.footer', ['hidden' => 'hidden', 'otherCSS' => '']) @endcomponent

    <script>
        const baseUrl = "{{ route('admin_monitor_userlog_activities_detil', ['type' => 'TYPE', 'id' => 'ID', 'sort' => 'SORT', 'by' => 'BY', 'search' => 'SEARCH', 'page' => 'PAGE']) }}";
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
            window.location.href= `{{ route('admin_monitor_userlog_activities_detil', [
                                        'type'   => $type,
                                        'id'     => $type_val,
                                        'sort'   => 'id',
                                        'by'     => 'asc',
                                        'search' => '-',
                                        'page'   => 1
                                    ]) }}`;
        }

        function sortChange() {
            const sort = document.getElementById('select-sort').value;
            const by = document.getElementById('select-by').value;
            let search = document.getElementById('txt-search').value;
            if(search == null || search == '') search = '-';
            const newUrl = baseUrl.replace('type', 'user')
                                .replace('id', `{{ $type_val; }}`)
                                .replace('SORT', 'user')
                                .replace('BY', by)
                                .replace('SEARCH', search)
                                .replace('PAGE', `{{ $page }}`);
            window.location.href= newUrl;
        }

        function byChange() {
            const sort = document.getElementById('select-sort').value;
            const by = document.getElementById('select-by').value;
            let search = document.getElementById('txt-search').value;
            if(search == null || search == '') search = '-';
            // window.location.href= `/admin/monitor-userlog-activities/user/{{ $type_val; }}/${sort}/${by}/${search}?page={{ $page }}`;
            const newUrl = baseUrl.replace('type', 'user')
                                .replace('id', `{{ $type_val; }}`)
                                .replace('SORT', sort)
                                .replace('BY', by)
                                .replace('SEARCH', search)
                                .replace('PAGE', `{{ $page }}`);
            window.location.href= newUrl;
        }

        function search() {
            const sort = document.getElementById('select-sort').value;
            const by = document.getElementById('select-by').value;
            let search = document.getElementById('txt-search').value;
            if(search == null || search == '') search = '-';
            const newUrl = baseUrl.replace('type', 'user')
                                .replace('id', `{{ $type_val; }}`)
                                .replace('SORT', sort)
                                .replace('BY', by)
                                .replace('SEARCH', search)
                                .replace('PAGE', 1);
            window.location.href= newUrl;
        }

        function pageChange() {
            const page = document.getElementById('select-page').value;
            const sort = document.getElementById('select-sort').value;
            const by = document.getElementById('select-by').value;
            let search = document.getElementById('txt-search').value;
            if(search == null || search == '') search = '-';
            const newUrl = baseUrl.replace('type', 'user')
                                .replace('id', `{{ $type_val; }}`)
                                .replace('SORT', sort)
                                .replace('BY', by)
                                .replace('SEARCH', search)
                                .replace('PAGE', page);
            window.location.href= newUrl;
        }

        function backup() {
            const signedUrl = `{{ URL::temporarySignedRoute('admin_monitor_userlog_activities_detil_backup', now()->addMinutes(60), ['id' => $data['user'][0]['id']]) }}`;
            window.open(signedUrl, '_blank');

        }

        function deleteAllActivities() {
            Swal.fire({
                title: "Anda yakin ingin menghapus semua data monitor user activities ini?",
                html: `<b>{{ $data['user'][0]['name'].' - '.$data['user'][0]['email'] }}</b>`,
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
                        const response = await axios.delete(`{{ route('admin_monitor_userlog_activities_detil_delete', ['id' => myfunction::enval($data['user'][0]['id'], true)]) }}`, {
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
                        console.info('Terjadi Error AdminMonitor-UserLogActivities-Detil-fDelete:', error)
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
    </script>
@endsection