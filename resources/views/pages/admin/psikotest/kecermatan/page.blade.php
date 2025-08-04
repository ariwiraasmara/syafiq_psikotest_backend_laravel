{{--
! Copyright @
! PT. Solusi Psikologi Banten
! Syafiq Marzuki
! Syahri Ramadhan Wiraasmara (ARI)
--}}
@php
    use App\Libraries\myfunction;

    $style_content = 'margin-bottom: 60px;';
    $style_fab = 'margin-bottom: 20px;';
    $style_paging = 'bottom: 1px; margin-bottom: 0px; padding: 10px;';

    if($roles > 1) {
        $style_content = 'margin-bottom: 130px;';
        $style_fab = 'margin-bottom: 75px;';
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
        <div class="mb-14 text-black">
            <h1 class='hidden'>Halaman {{ $appbar_title }} | Admin</h1>

            <div id="data-container">
                @forelse($data as $data)
                    <div class="bg-slate-50 border-b-2 p-3 rounded-t-md mt-2 mb-4 text-black border-black shadow-xl">
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
                @empty
                    <div class="mt-2">
                        <div class="p-4 bg-white text-center text-black text-xl shadow-xl">
                            Belum Ada Data Psikotes!
                        </div>
                    </div>
                @endforelse
            </div>

            <button type="button" class="fab bg-blue-700 shadow-xl" style="{{ $style_fab; }}" onclick="window.location.href = `{{ route('admin_psikotest_kecermatan_baru') }}`">
                <a href="#" rel="nofollow" title="Psikotest Kecermatan Baru">
                    +
                </a>
            </button>
        </div>
    </div>

    @if($roles > 1)
        @component('components.admin.navigasibawah', ['navval' => $navval, 'roles'=>$roles]) @endcomponent
    @endif
    @if($roles == 1)
    @component('components.admin.menusidebar', ['navval' => $navval, 'email' => $email, 'roles' => $roles]) @endcomponent
    @endif
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
                                _token: `{{ csrf_token() }}`,
                                unique: '{{ $unique; }}',
                                id: id,
                                deleted_at: `{{ date('Y-m-d H:i:s') }}`,
                            }, {
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