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
        'link_back'    => route('admin_psikotest_kecermatan_detil', ['id' => $id1]),
        'appbar_title' => $appbar_title,
        'sidebar'      => true,
        'roles'        => $roles
    ]) @endcomponent

    <div class="p-4 text-black" style="margin-bottom: 0px;">
        <h1 class='hidden'>Halaman {{ $appbar_title }} | Admin</h1>

        <div class="">
            <form action="{{ route('admin_psikotest_kecermatan_detil_edit', ['id1' => $id1, 'id2' => $id2]); }}" method="POST">
                @method('PUT')
                @csrf()
                <input type="hidden" id="unique" name="unique" value="{{ $unique }}" readonly />
                
                <input  type="number" id="txt-soalA" name="soalA" required focused
                        placeholder="Soal A..." label="Soal A..." value="{{ $data['soal'][0][0]; }}"
                        class="w-full mt-4 border-white border-2 p-2 rounded-lg text-white"
                        style="background-color: rgba(0, 0, 0, 0.5)"
                />

                <input  type="number" id="txt-soalB" name="soalB" required focused
                        placeholder="Soal B..." label="Soal B..." value="{{ $data['soal'][0][1]; }}"
                        class="w-full mt-4 border-white border-2 p-2 rounded-lg text-white"
                        style="background-color: rgba(0, 0, 0, 0.5)"
                />

                <input  type="number" id="txt-soalC" name="soalC" required focused
                        placeholder="Soal C..." label="Soal C..." value="{{ $data['soal'][0][2]; }}"
                        class="w-full mt-4 border-white border-2 p-2 rounded-lg text-white"
                        style="background-color: rgba(0, 0, 0, 0.5)"
                />

                <input  type="number" id="txt-soalD" name="soalD" required focused
                        placeholder="Soal D..." label="Soal D..." value="{{ $data['soal'][0][3]; }}"
                        class="w-full mt-4 border-white border-2 p-2 rounded-lg text-white"
                        style="background-color: rgba(0, 0, 0, 0.5)"
                />

                <input  type="number" id="txt-jawaban" name="jawaban" required focused
                        placeholder="Jawaban..." label="Jawaban..." value="{{ $data['jawaban']; }}"
                        class="w-full mt-4 border-white border-2 p-2 rounded-lg text-white"
                        style="background-color: rgba(0, 0, 0, 0.5)"
                />

                <div class="">
                    <button type="button" class="mt-4 p-2 bg-blue-700 hover:bg-blue-500 shadow-xl text-white rounded-lg text-center w-full" onclick="submit()">
                        Simpan
                    </button>

                    <button type="button" class="mt-4 p-2 bg-pink-700 hover:bg-pink-500 shadow-xl text-white rounded-lg text-center w-full" onclick="window.location.href= `{{ route('admin_psikotest_kecermatan_detil', ['id' => $id1]); }}`">
                        Kembali
                    </button>
                </div>
            </form>
        </div>
    </div>

    @component('components.footer', ['hidden' => 'hidden', 'otherCSS' => '']) @endcomponent
@endsection