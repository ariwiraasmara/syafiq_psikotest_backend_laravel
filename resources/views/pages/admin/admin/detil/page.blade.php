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
        'sidebar'      => false,
        'link_back'    => $link_back,
        'appbar_title' => $appbar_title,
        'roles'        => $roles,
        'navval'       => $navval,
        'email'        => $email
    ]) @endcomponent

    <div class="p-4 text-black" style="margin-bottom: 10px;">
        <div class="items-center justify-items-center">
            <img src="{{ $foto['foto']; }}" height="150" width="150" class="bg-white border-white border-2 rounded-full shadow-xl" alt="{{ $foto['alt_foto']; }}" title="{{ $data['user'][0]['name'] }}" />
        </div>
        <form action="{{ route('admin_anggota_update_foto', ['type' => 'php', 'id' => myfunction::enval($data['user'][0]['id'], true)]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" id="unique" name="unique" value="{{ $unique }}" readonly hidden />
            <div class="mt-4 flex flex-row w-full">
                <div class="basis-1/2">
                    <input type="file" id="file_foto" name="file_foto" accept="image/png, image/webp" class="p-2 w-full block bg-white rounded-xl shadow-xl" />
                </div>
                <div class="basis-1/2">
                    <button type="submit" id="btn-form-foto-submit" class="p-2 w-full block bg-blue-700 text-white rounded-xl shadow-xl">Upload Foto</button>
                </div>
            </div>
        </form>
        <div class="p-4 mt-6 bg-white rounded-xl shadow-xl">
            <p style="border-bottom: 1px solid #eee;"><span class="font-bold">Roles :</span> {{ $data['user'][0]['roles']; }}</p>
            <p style="border-bottom: 1px solid #eee;"><span class="font-bold">Nama :</span> {{ $data['user'][0]['name']; }}</p>
            <p style="border-bottom: 1px solid #eee;"><span class="font-bold">Email :</span> {{ $data['user'][0]['email']; }}</p>
            <p style="border-bottom: 1px solid #eee;"><span class="font-bold">No. Identitas :</span> {{ $data['user'][0]['no_identitas']; }}</p>
            <p style="border-bottom: 1px solid #eee;"><span class="font-bold">Tanggal Lahir :</span> {{ $data['user'][0]['tgl_lahir']; }}</p>
            <p style="border-bottom: 1px solid #eee;"><span class="font-bold">Jenis Kelamin :</span> {{ $data['user'][0]['jk']; }}</p>
            <p style="border-bottom: 1px solid #eee;"><span class="font-bold">Status :</span> {{ $data['user'][0]['status']; }}</p>
            <p style="border-bottom: 1px solid #eee;"><span class="font-bold">Agama :</span> {{ $data['user'][0]['agama']; }}</p>
            <p style="border-bottom: 1px solid #eee;"><span class="font-bold">Alamat :</span> {{ $data['user'][0]['alamat']; }}</p>
            <p style="border-bottom: 1px solid #eee;"><span class="font-bold">Dibuat :</span> {{$data['user'][0]['created_at']; }}</p>
            <p style="border-bottom: 1px solid #eee;"><span class="font-bold">Diperbaharui :</span> {{$data['user'][0]['updated_at']; }}</p>
            <p style="border-bottom: 1px solid #eee;"><span class="font-bold">Dihapus :</span> {{$data['user'][0]['deleted_at']; }}</p>
        </div>

        @if($roles == $data['user'][0]['roles'])
        <div class="mt-4">
            <div class="flex flex-row mt-2">
                <div class="basis-1/3">
                    <span class='text-center'>
                        <button id="btn-edit-password" class="p-2 w-full block bg-blue-700 text-white rounded-xl shadow-xl" onclick="modalEditPassword()">
                            Edit Password
                        </button>
                    </span>
                </div>
                <div class="basis-1/3">
                    <span class='text-center'>
                        <a href="{{ route('admin_anggota_edit', ['id' => myfunction::enval($data['user'][0]['id'], true)]) }}" rel="nofollow" title="Edit Data Peserta {{ $data['user'][0]['name'] }}" class="p-2 w-full block bg-blue-700 text-white rounded-xl shadow-xl">
                            <ion-icon name="pencil-outline"></ion-icon>
                        </a>
                    </span>
                </div>
                <div class="basis-1/3">
                    <span class='text-center'>
                        <a href="{{ route('admin_anggota_softdelete', ['id' => myfunction::enval($data['user'][0]['id'], true)])}}" rel="nofollow" title="Hapus Data Peserta {{ $data['user'][0]['name'] }}" class="p-2 w-full block bg-red-700 text-white rounded-xl shadow-xl">
                            <ion-icon name="trash-outline"></ion-icon>
                        </a>
                    </span>
                </div>
            </div>
        </div>
        @endif

        @component('components.admin.admin.tabadmindetil', [
            'data_token'    => $data['pat'][0],
            'data_device'   => $data['device_history'],
            'session_roles' => $roles,
            'user_roles'    => $data['user'][0]['roles']
        ]) @endcomponent
    </div>

    @component('components.footer', ['hidden' => 'hidden', 'otherCSS' => '']) @endcomponent

    @if($roles == $data['user'][0]['roles'])
        <script>
            async function modalEditPassword() {
                try {
                    const { value: password } = await Swal.fire({
                        title: "Enter your password",
                        icon: "info",
                        input: "password",
                        inputLabel: "Password",
                        inputPlaceholder: "Enter your password",
                        inputAttributes: {
                            maxlength: "255",
                            autocapitalize: "off",
                            autocorrect: "off"
                        },
                        showConfirmButton: true,
                        showCancelButton: true,
                        confirmButtonText: "Ya",
                        cancelButtonText: "Batalkan",
                        showLoaderOnConfirm: true,
                    });

                    if(password) {
                        axios.defaults.withCredentials = true;
                        axios.defaults.withXSRFToken = true;
                        const csrfToken = await axios.get(`/sanctum/csrf-cookie`);
                        const response = await axios.post(`{{ route('admin_anggota_update_password', ['id' => $id]) }}`, {
                            unique: '{{ $unique; }}',
                            password: password
                        }, {
                            withCredentials: true,
                            headers: {
                                'Content-Type': 'application/json',
                                'XSRF-TOKEN': csrfToken,
                                'tokenlogin': '{{ $unique; }}',
                            }
                        });
                        console.info(response);
                        if(response.data.success) {
                            Swal.fire({
                                title: "Updated!",
                                text: "Password Berhasil Diperbaharui",
                                icon: "success"
                            });
                        }
                    }
                }
                catch(error) {
                    console.info('Terjadi Error Profilku-fDelte:', error)
                }
            }

            async function modalToken1() {
                Swal.fire({
                    title: "Update Token 1?",
                    text: "Setelah Klik 'OK' Anda Akan Logout",
                    icon: "info",
                    showConfirmButton: true,
                    showCancelButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href= `{{ route('admin_anggota_update_remembertoken', ['roles' => $roles, 'type' => 'php']); }}`;
                    }
                });
            }
        </script>
    @endif
@endsection