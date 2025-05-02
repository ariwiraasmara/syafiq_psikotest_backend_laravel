{{--
! Copyright @
! Syafiq
! Syahri Ramadhan Wiraasmara (ARI)
--}}
@php
    use App\Libraries\myfunction;
@endphp
@extends('layouts.app')
@section('content')
    @component('components.appbarku', [
        'nama'         => $nama,
        'link_back'    => null,
        'appbar_title' => $appbar_title,
    ]) @endcomponent

    <div class="p-4 text-black" style="margin-bottom: 130px;">
        <div class="mb-14 text-black">
            <h1 class='hidden'>Halaman {{ $appbar_title }} | Admin</h1>

            <div id="data-container">
                @foreach($data as $data)
                    <div class="bg-slate-50 border-b-2 p-3 rounded-t-md mt-2 text-black border-black">
                        <div class="static">
                            <div>
                                <a href="{{ route('admin_psikotest_kecermatan_detil', ['id' => myfunction::enval($data['id'], true)]).'?page=1'}}">
                                    {{ $data['kolom_x'] }}
                                </a>
                            </div>
                            <div class="text-right" style="margin-top: -23px;">
                                <a href="{{ route('admin_psikotest_kecermatan_edit', ['id' => myfunction::enval($data['id'], true)]) }}" rel="nofollow" title="{{ 'Edit Data '.$data['kolom_x'] }}" style="margin-right: 15px;">
                                    <ion-icon name="pencil-outline"></ion-icon>
                                    <span class="hidden">Edit</span>
                                </a>
                                <span onclick="fDelete('{{myfunction::enval($data['id'], true)}}', '{{$data['kolom_x']}}')">
                                    <ion-icon name="trash-outline"></ion-icon>
                                    <span class="hidden">Delete</span>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="button" class="fab bg-blue-700" style="margin-bottom: 75px;" onclick="window.location.href = `{{ route('admin_psikotest_kecermatan_baru') }}`">
                <a href="#" rel="nofollow" title="Psikotest Kecermatan Baru">
                    +
                </a>
            </button>
        </div>
    </div>

    @component('components.admin.navigasibawah', ['navval' => $navval]) @endcomponent
    @component('components.footer', ['hidden' => 'hidden', 'otherCSS' => '']) @endcomponent

    <script>
        async function fDelete(id, kolom_x) {
            if(validator.isBase64(id)) {
                Swal.fire({
                    title: "Anda yakin ingin menghapus data Psikotest Kecermatan ini?",
                    html: `Semua data <b>${kolom_x}</b> yang ada didalamnya juga akan terhapus!`,
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
                            const response = await axios.delete(`/public/admin/psikotest/kecermatan-delete/${DOMPurify.sanitize(id)}`, {
                                withCredentials: true,
                                headers: {
                                    'Content-Type': 'application/json',
                                    'XSRF-TOKEN': csrfToken,
                                    'tokenlogin': '{{ $unique; }}',
                                }
                            });
                            // Hapus item dari state variabels setelah sukses
                            if(response.data.success) {
                                setTimeout(() => {
                                    window.location.href = `{{ route('admin_psikotest_kecermatan') }}`;
                                }, 1000);
                            }
                        } catch (error) {
                            console.info('Terjadi Error AdminPsikotestKecermatan-fDelete', error);
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