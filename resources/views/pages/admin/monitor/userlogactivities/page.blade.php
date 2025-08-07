{{--
! Copyright @
! PT. Solusi Psikologi Banten
! Syafiq Marzuki
! Syahri Ramadhan Wiraasmara (ARI)
--}}
@php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
use App\Libraries\myfunction;
use Illuminate\Support\Facades\URL;
$style_content = 'margin-bottom: 60px;';
$style_fab = 'margin-bottom: 23px;';
$style_paging = 'bottom: 1px; margin-bottom: 0px; padding: 10px;';

if($roles > 1) {
    $style_content = 'margin-bottom: 130px;';
    $style_fab = 'margin-bottom: 90px;';
    $style_paging = 'bottom: 1px; margin-bottom: 70px; padding: 10px;';
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
                    <option value="users_activities.id" @if($sort == 'users_activities.id') selected @endif >ID</option>
                    <option value="Users.name" @if($sort == 'Users.name') selected @endif >Nama</option>
                    <option value="Users.email" @if($sort == 'Users.email') selected @endif >Email</option>
                    <option value="users_activities.tanggal" @if($sort == 'users_activities.tanggal') selected @endif >Tanggal</option>
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
        <div class="mt-2">
            <span class="font-bold">Lihat Detil Admin User</span>
            <div class="">
                <select id="select-userdetail" title="Admin User" class="p-2 rounded-sm bg-white w-full shadow-xl" style="padding: 5px;" onchange="byChange_AdminUser();">
                    <option value="" disabled selected>Pilih Admin User...</option>
                    @if($alluser)
                        @foreach($alluser as $user)
                            <option value="{{ $user['id'] }}">{{ $user['name'].' - '.$user['email'] }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div id="data-container" style="width: 100%; overflow-x: scroll;">
            <table class="bg-white text-black shadow-xl border-spacing-2 table-auto mt-6" style="width: 100%; overflow-x: scroll;">
                <thead>
                    <tr>
                        <td class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">ID</td>
                        <td class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">Nama</td>
                        <td class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">Tanggal</td>
                        <td class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">IP Address</td>
                        <td class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">Path</td>
                        <td class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">Event</td>
                        <td class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">Deskripsi</td>
                        <td class="text-center font-bold" style="padding: 5px; border: 3px solid #000;">User Agent</td>
                    </tr>
                </thead>

                <tbody>
                    @if($data)
                        @foreach($data as $item)
                            <tr onclick="onDetil({{ $item['id'] }})">
                                <td class="text-right" style="padding: 5px; border-left: 3px solid #000; border-right: 3px solid #000; border-bottom: 1px solid #ddd;">{{ $item['id']; }}</td>
                                <td style="padding: 5px; border-right: 1px solid #eee; border-bottom: 1px solid #ddd;">
                                    {{ $item['name']; }}<br/>
                                    <span class="italic">{{ '('.$item['email'].')'; }}</span>
                                </td>
                                <td style="padding: 5px; border-right: 1px solid #eee; border-bottom: 1px solid #ddd;">{{ $item['tanggal']; }}</td>
                                <td style="padding: 5px; border-right: 1px solid #eee; border-bottom: 1px solid #ddd;">{{ $item['ip_address']; }}</td>
                                <td style="padding: 5px; border-right: 1px solid #eee; border-bottom: 1px solid #ddd;">{{ $item['path']; }}</td>
                                <td style="padding: 5px; border-right: 1px solid #eee; border-bottom: 1px solid #ddd;">{{ $item['event']; }}</td>
                                <td style="padding: 5px; border-right: 1px solid #eee; border-bottom: 1px solid #ddd;">{{ $item['deskripsi']; }}</td>
                                <td style="padding: 5px; border-right: 3px solid #000; border-bottom: 1px solid #ddd;">{{ $item['user_agent']; }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">
                                <h3 class="font-bold text-lg text-center">Belum Ada Data!</h3>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="flex flex-row">
            <div class="basis-1/2">
                <button type="button" class="p-2 bg-blue-700 text-white shadow-xl w-full" onclick="backup()">Backup</button>
            </div>
            <div class="basis-1/2">
                <button type="button" class="p-2 bg-red-700 text-white shadow-xl w-full" onclick="deleteAllActivities()">Hapus</button>
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

    @if($roles == 1)
        @component('components.admin.menusidebar', ['navval' => $navval, 'email' => $email, 'roles' => $roles]) @endcomponent
    @endif
    @component('components.footer', ['hidden' => 'hidden', 'otherCSS' => '']) @endcomponent

    <script>
        const baseUrl = "{{ route('admin_monitor_userlog_activities', ['sort' => 'SORT', 'by' => 'BY', 'search' => 'SEARCH', 'page' => 'PAGE']) }}";
        const detilURL = "{{ route('admin_monitor_userlog_activities_detil', ['type' => 'TYPE', 'id' => 'ID', 'sort' => 'SORT', 'by' => 'BY', 'search' => 'SEARCH', 'page' => 'PAGE']) }}";
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
            window.location.href= `{{ route('admin_monitor_userlog_activities', ['sort' => 'Users.name', 'by' => 'asc', 'search' => '-', 'page' => 1]) }}`;
        }

        function sortChange() {
            const page = document.getElementById('select-page').value;
            const sort = document.getElementById('select-sort').value;
            const by = document.getElementById('select-by').value;
            let search = document.getElementById('txt-search').value;
            if(search == null || search == '') search = '-';

            const newUrl = baseUrl.replace('SORT', sort)
                                .replace('BY', by)
                                .replace('SEARCH', search)
                                .replace('PAGE', page);
            window.location.href= newUrl;
        }

        function byChange() {
            const sort = document.getElementById('select-sort').value;
            const by = document.getElementById('select-by').value;
            let search = document.getElementById('txt-search').value;
            if(search == null || search == '') search = '-';
            window.location.href= `/admin/monitor-userlog-activities/${sort}/${by}/${search}?page=`;
            const newUrl = baseUrl.replace('SORT', sort)
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
            const newUrl = baseUrl.replace('SORT', sort)
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
            const newUrl = baseUrl.replace('SORT', sort)
                                .replace('BY', by)
                                .replace('SEARCH', search)
                                .replace('PAGE', page);
            window.location.href= newUrl;
        }

        function byChange_AdminUser() {
            const val = document.getElementById('select-userdetail').value;
            window.location.href= `/admin/monitor-userlog-activities-detil/user/${val}/id/asc/-?page=1`;
            const newUrl = detilURL.replace('TYPE', 'user')
                                .replace('ID', val)
                                .replace('SORT', 'id')
                                .replace('BY', 'asc')
                                .replace('SEARCH', '-')
                                .replace('PAGE', 1);
            window.location.href= newUrl;
        }

        function onDetil(val) {
            const newUrl = detilURL.replace('TYPE', 'id')
                                .replace('ID', val)
                                .replace('SORT', 'id')
                                .replace('BY', 'asc')
                                .replace('SEARCH', '-')
                                .replace('PAGE', 1);
            window.location.href= newUrl;
        }

        function backup() {
            const signedUrl = `{{ URL::temporarySignedRoute('admin_monitor_userlog_activities_backup_all', now()->addMinutes(1)) }}`;
            window.open(signedUrl, '_blank');
        }

        function deleteAllActivities() {
            Swal.fire({
                title: "Anda yakin ingin menghapus semua data monitor semua user activities ini?",
                html: `<b>Semua User Admin</b>`,
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
                        const response = await axios.delete(`{{ route('admin_monitor_userlog_activities_truncate') }}`, {
                            withCredentials: true,
                            headers: {
                                'Content-Type': 'application/json',
                                'XSRF-TOKEN': csrfToken,
                                'tokenlogin': '{{ $unique; }}',
                            }
                        });
                        console.info(response);
                        if(response.data.success) {
                            setTimeout(() => {
                                // refresh();
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