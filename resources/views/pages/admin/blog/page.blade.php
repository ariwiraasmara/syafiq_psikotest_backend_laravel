@php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
    use App\Libraries\myfunction;

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
        'roles'        => $roles,
        'navval'       => $navval
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
                    <option value="title" @if($sort == 'title') selected @endif >Judul</option>
                    <option value="category" @if($sort == 'category') selected @endif >Kategori</option>
                    <option value="created_at" @if($sort == 'created_at') selected @endif >Tanggal Dibuat</option>
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
                @forelse ($data as $data)
                    <div class="bg-slate-50 border-b-2 p-3 rounded-t-md mt-2 mb-4 border-black shadow-xl">
                        <div class="static">
                            <div>
                                <span class="font-bold">{{ $data['title'] }}</span><br/>
                                <span class="">Kategori: {{ $data['category'] }}</span><br/>
                                <span class="">Oleh : {{ $data['name'] }}</span><br/>
                                <span class="italic">Dibuat: {{ myfunction::formatTimestamp($data['created_at']) }}</span><br/>
                                @if(($data['updated_at'] == $data['created_at']) || ($data['updated_at'] == null))
                                    <span class="italic">Diperbaharui:</span>
                                @else
                                    <span class="italic">Diperbaharui: {{ myfunction::formatTimestamp($data['updated_at']) }}</span>
                                @endif
                            </div>
                            <div class="text-center text-xs" style="margin-top: 10px;">
                                @php
                                    if($data['status'] == 'draft') echo '<span class="p-2 rounded-lg" style="background-color: #aaa;">Draft</span>';
                                    else if($data['status'] == 'public') echo '<span class="p-2 rounded-lg" style="background-color: #0f0;">Public</span>';
                                    else if($data['status'] == 'deleted')echo '<span class="p-2 rounded-lg" style="background-color: #f33;">Deleted</span>';
                                @endphp
                                <a href="{{ route('admin_blog_detail', ['id' => myfunction::enval($data['id'], true)]); }}" rel="follow" class="p-2 rounded-lg bg-blue-700 text-white text-center" style="margin-left: 5px;">
                                    <span class="">Detil</span>
                                </a>
                                <a href="{{ route('admin_blog_edit', ['id' => myfunction::enval($data['id'], true)]); }}" rel="nofollow" class="p-2 rounded-lg bg-blue-700 text-white text-center" style="margin-right: 5px; margin-left: 5px;">
                                    <ion-icon name="pencil-outline"></ion-icon>
                                    <span class="hidden">Edit</span>
                                </a>
                                <span onclick="fDelete('{{ myfunction::enval($data['id'], true); }}', '{{ $data['title']; }}')" class="p-2 rounded-lg bg-pink-700 text-white text-center">
                                    <ion-icon name="trash-outline"></ion-icon>
                                    <span class="hidden">Delete</span>
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="mt-2">
                        <div class="p-4 bg-white text-center text-black text-xl shadow-xl">
                            Belum Ada Data Blog!
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        <button type="button" class="fab bg-blue-700" style="{{ $style_fab }}" onclick="window.location.href = '{{ route('admin_blog_baru') }}'">
            <a href="#" rel="nofollow" title="Blog Baru">
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

        async function fDelete(id, title) {
            if(validator.isBase64(id)) {
                Swal.fire({
                    title: "Anda yakin ingin menghapus data blog ini?",
                    html: `<b>${title}</b>`,
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
                            const response = await axios.delete(`/public/admin/blog-delete/${id}`, {
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
                            console.info('Terjadi Error AdminBlog-fDelete:', error)
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
            window.location.href= `{{ route('admin_blog', ['sort' => 'blog', 'by' => 'asc', 'search' => '-']) }}?page=1`;
        }

        function sortChange() {
            const sort = document.getElementById('select-sort').value;
            const by = document.getElementById('select-by').value;
            let search = document.getElementById('txt-search').value;
            if(search == null || search == '') search = '-';
            window.location.href= `/public/admin/blog/${sort}/${by}/${search}?page={{ $page }}`;
        }

        function byChange() {
            const sort = document.getElementById('select-sort').value;
            const by = document.getElementById('select-by').value;
            let search = document.getElementById('txt-search').value;
            if(search == null || search == '') search = '-';
            window.location.href= `/public/admin/blog/${sort}/${by}/${search}?page={{ $page }}`;
        }

        function search() {
            const sort = document.getElementById('select-sort').value;
            const by = document.getElementById('select-by').value;
            let search = document.getElementById('txt-search').value;
            if(search == null || search == '') search = '-';
            window.location.href= `/public/admin/blog/${sort}/${by}/${search}?page=1`;
        }
        
        function pageChange() {
            const page = document.getElementById('select-page').value;
            const sort = document.getElementById('select-sort').value;
            const by = document.getElementById('select-by').value;
            let search = document.getElementById('txt-search').value;
            if(search == null || search == '') search = '-';
            window.location.href= `/public/admin/blog/${sort}/${by}/${search}?page=${page}`;
        }
    </script>
@endsection