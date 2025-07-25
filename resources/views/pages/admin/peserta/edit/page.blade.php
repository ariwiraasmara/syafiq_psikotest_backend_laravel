{{--
! Copyright @
! PT. Solusi Psikologi Banten
! Syafiq Marzuki
! Syahri Ramadhan Wiraasmara (ARI)
--}}
@extends('layouts.app')
@section('content')
    @component('components.appbarku', [
        'nama'         => $nama,
        'email'        => $email,
        'link_back'    => route('admin_peserta_detil', ['id' => $id_data]),
        'appbar_title' => $appbar_title,
        'sidebar'      => true,
        'roles'        => $roles
    ]) @endcomponent

    <div class="p-4 text-black" style="margin-bottom: 120px;">
        <h1 class='hidden'>Halaman {{ $appbar_title }} | Admin</h1>

        <div class="">
            <form action="{{ route('admin_peserta_edit', ['id' => $id_data]); }}" method="POST">
                @method('PUT')
                @csrf()
                <input type="hidden" id="unique" name="unique" value="{{ $unique }}" readonly />

                <div class="text-black">
                    <p><span class='font-bold'>Nama :</span> {{ $data['nama']; }}</p>
                    <p><span class='font-bold'>Nomor Identitas :</span> {{ $data['no_identitas']; }}</p>
                </div>

                <div class="">
                    <input  type="email" id="txt-email" name="email" required focused
                            placeholder="Email..." label="Email..." value="{{ $data['email']; }}"
                            class="w-full mt-4 border-white border-2 p-2 rounded-lg text-white"
                            style="background-color: rgba(0, 0, 0, 0.5)"
                    />
                    <input  type="date" id="txt-tgl_lahir" name="tgl_lahir" required focused
                            placeholder="Tanggal Lahir..." label="Tanggal Lahir..." value="{{ $data['tgl_lahir']; }}"
                            class="w-full mt-4 border-white border-2 p-2 rounded-lg text-white"
                            style="background-color: rgba(0, 0, 0, 0.5)"
                    />
                    <input  type="text" id="txt-asal" name="asal" required focused
                            placeholder="Asal..." label="Asal..." value="{{ $data['asal']; }}"
                            class="w-full mt-4 border-white border-2 p-2 rounded-lg text-white"
                            style="background-color: rgba(0, 0, 0, 0.5)"
                    />
                </div>

                <div class="">
                    <button type="submit" class="mt-4 p-2 bg-blue-700 hover:bg-blue-500 shadow-xl text-white rounded-lg text-center w-full">
                        Simpan
                    </button>

                    <button type="button" class="mt-4 p-2 bg-pink-700 hover:bg-pink-500 shadow-xl text-white rounded-lg text-center w-full" onclick="window.location.href= `{{ route('admin_peserta_detil', ['id' => $id]) }}`">
                        Kembali
                    </button>
                </div>
            </form>
        </div>
    </div>

    @component('components.footer', ['hidden' => 'hidden', 'otherCSS' => '']) @endcomponent
@endsection