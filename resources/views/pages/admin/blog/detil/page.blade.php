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
        'sidebar'      => false,
        'link_back'    => route('admin_blog', ['sort' => 'title', 'by' => 'asc', 'search' => '-']).'?page=1',
        'appbar_title' => $appbar_title,
        'roles'        => $roles,
        'navval'       => $navval
    ]) @endcomponent

    <div class="p-4 text-black" style="margin-bottom: 10px;">
        <h2 class="hidden">Content Blog Detil</h2>
        <h3 class="text-2xl font-bold">{{ $data['title'] }}</h3>
        <h4 class="font-bold">Kategori: {{ $data['category'] }}</h4>
        <h4 class="font-bold">Penulis: {{ $data['name']; }}</h4>
        <h4 class="italic">Dibuat: {{ myfunction::formatTimestamp($data['created_at']); }}</h4>

        @if(($data['updated_at'] != '') || ($data['updated_at'] != null))
        <h4 class="italic">Diperbaharui: {{ myfunction::formatTimestamp($data['updated_at']); }}</h4>
        @endif

        @if(($data['deleted_at'] != '') || ($data['deleted_at'] != null))
        <h4 class="italic">Dihapus: {{ myfunction::formatTimestamp($data['deleted_at']); }}</h4>
        @endif

        <div class="mt-4 text-sm">
            <a href="{{ route('admin_blog_edit', ['id' => myfunction::enval($data['id'], true)]); }}" rel="nofollow" class="p-2 rounded-lg bg-blue-700 text-white text-center shadow-xl" style="margin-right: 5px; margin-left: 5px;">
                <ion-icon name="pencil-outline"></ion-icon>
                <span class="ml-2">Edit</span>
            </a>
            <span onclick="fDelete('{{ myfunction::enval($data['id'], true); }}', '{{ $data['title']; }}')" class="p-2 rounded-lg bg-pink-700 text-white text-center shadow-xl">
                <ion-icon name="trash-outline"></ion-icon>
                <span class="ml-2">Delete</span>
            </span>
        </div>

        <div class="p-4 mt-6 bg-white rounded-xl text-black shadow-xl">
            {!! $data['content'] !!}
        </div>
    </div>

    <script>
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
                            console.info('Terjadi Error AdminBlogDetil-fDelete:', error)
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
    </script>
@endsection