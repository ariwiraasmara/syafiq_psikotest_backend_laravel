@php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
    use App\Libraries\myfunction;
    $style_content = 'margin-bottom: 60px;';
    $style_fab = 'margin-bottom: 23px;';
    $style_paging = 'bottom: 1px; margin-bottom: 0px; padding: 10px;';
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
        <h2 class='hidden'>Konten Halaman {{ $appbar_title }} | Admin</h1>
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
                    <option value="name" @if($sort == 'name') selected @endif >Nama</option>
                    <option value="email" @if($sort == 'email') selected @endif >Email</option>
                    <option value="created_at" @if($sort == 'created_at') selected @endif >Tangal Dibuat</option>
                    <option value="updated_at" @if($sort == 'updated_at') selected @endif >Tanggal Diperbaharui</option>
                    <option value="deleted_at" @if($sort == 'deleted_at') selected @endif >Tanggal Dihapus</option>
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
                @foreach($data as $data)
                    @php
                        $isactive = false;
                        $isactive_html = '';
                        if(($data['deleted_at'] == null) || ($data['deleted_at'] == '') || $data['deleted_at'] == '0000-00-00 00:00:00') {
                            $isactive = true;
                            $isactive_html = '<span class="text-white text-sm rounded-lg mr-2" style="background: #0a0; padding: 4px;">Akun Aktif</span>';
                        }
                        else {
                            $isactive = false;
                            $isactive_html = '<span class="text-white text-sm rounded-lg mr-2" style="background: #f00; padding: 4px;">Akun Tidak Aktif</span>';
                        }

                        $roles_desc = '';
                        if($data['roles'] > 1) $roles_desc = 'admin';
                        else $roles_desc = 'super admin';
                    @endphp
                    <div class="bg-slate-50 border-b-2 p-3 rounded-t-md mt-2 mb-4 border-black shadow-xl">
                        <div class="static">
                            <div>
                                <span class="font-bold">{{ $data['name'] }}</span>
                                <br/>
                                <span>{{ $data['email'] }}</span>
                                <br/>
                                <span>{{ ucfirst($roles_desc) }}</span>
                                <br/>
                                <span class="italic">dibuat : {{ myfunction::formatTimestamp($data['created_at']) }}</span>
                                <br/>
                                @if(($data['updated_at'] != '') || ($data['updated_at'] != null))
                                    <span class="italic">diperbaharui : {{ myfunction::formatTimestamp($data['updated_at']) }}</span>
                                @endif
                                @if(($data['deleted_at'] != null) || ($data['deleted_at'] != ''))
                                    <br/>
                                    <span class="italic">dihapus : {{ myfunction::formatTimestamp($data['deleted_at']) }}</span>
                                @endif
                            </div>
                            <div class="mt-2 text-center">
                                @php echo $isactive_html; @endphp
                                <a href="{{ route('admin_anggota_detil', ['id' => myfunction::enval($data['id'], true)]) }}" rel="follow" title="{{ 'Detail '.$data['name'] }}" class="bg-blue-700 text-white text-center p-2 rounded-lg mr-2">
                                    <ion-icon name="eye-outline"></ion-icon>
                                    <span class="hidden">Detil</span>
                                </a>
                                @if(($roles != $data['roles']) && ($data['roles'] > 1))
                                    <a href="{{ route('admin_anggota_edit', ['id' => myfunction::enval($data['id'], true)]); }}" rel="nofollow" title="{{ 'Edit '.$data['name'] }}" class="bg-blue-700 text-white text-center p-2 rounded-lg mr-2">
                                        <ion-icon name="pencil-outline"></ion-icon>
                                        <span class="hidden">Edit</span>
                                    </a>
                                    <span onclick="fDelete('{{ myfunction::enval($data['id'], true); }}', '{{ $data['name']; }}', '{{ $data['email']; }}')" title="{{ 'Delete '.$data['name'] }}" class="bg-red-700 text-white text-center p-2 rounded-lg">
                                        <ion-icon name="trash-outline"></ion-icon>
                                        <span class="hidden">Delete</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <button type="button" class="fab bg-blue-700" style="{{ $style_fab }}" onclick="window.location.href = '{{ route('admin_anggota_baru') }}'">
            <a href="#" rel="nofollow" title="Variabel Baru">
                +
            </a>
        </button>
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
        const baseUrl = "{{ route('admin_anggota', ['sort' => 'SORT', 'by' => 'BY', 'search' => 'SEARCH', 'page' => 'PAGE']) }}";
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

        async function fDelete(id, nama, email) {
            if(validator.isBase64(id)) {
                const urlDelete = `{{ route('admin_anggota_delete', ['id' => 'ID']) }}`;
                const newUrl = urlDelete.replace('ID', DOMPurify.sanitize(id));
                Swal.fire({
                    title: "Anda yakin ingin menghapus data admin ini?",
                    html: `<b>${DOMPurify.sanitize(nama)}</b><br/><b>${DOMPurify.sanitize(email)}</b>`,
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
                            const response = await axios.delete(newUrl, {
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
            window.location.href= `{{ route('admin_anggota', ['sort' => 'name', 'by' => 'asc', 'search' => '-']) }}?page=1`;
        }

        function sortChange() {
            const sort = document.getElementById('select-sort').value;
            const by = document.getElementById('select-by').value;
            let search = document.getElementById('txt-search').value;
            if(search == null || search == '') search = '-';
            const newUrl = baseUrl.replace('SORT', sort)
                                .replace('BY', by)
                                .replace('SEARCH', search)
                                .replace('PAGE', `{{ $page }}`);
        }

        function byChange() {
            const sort = document.getElementById('select-sort').value;
            const by = document.getElementById('select-by').value;
            let search = document.getElementById('txt-search').value;
            if(search == null || search == '') search = '-';
            const newUrl = baseUrl.replace('SORT', sort)
                                .replace('BY', by)
                                .replace('SEARCH', search)
                                .replace('PAGE', `{{ $page }}`);
        }

        function search() {
            const sort = document.getElementById('select-sort').value;
            const by = document.getElementById('select-by').value;
            let search = document.getElementById('txt-search').value;
            if(search == null || search == '') search = '-';
            window.location.href= `/public/admin/anggota/${sort}/${by}/${search}?page=1`;
        }
        
        function pageChange() {
            const page = document.getElementById('select-page').value;
            const sort = document.getElementById('select-sort').value;
            const by = document.getElementById('select-by').value;
            let search = document.getElementById('txt-search').value;
            if(search == null || search == '') search = '-';
            window.location.href= `/public/admin/anggota/${sort}/${by}/${search}?page=${page}`;
        }
    </script>
@endsection