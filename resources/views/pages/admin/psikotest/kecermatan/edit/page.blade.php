@php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
@endphp
@extends('layouts.app')
@section('content')
    @component('components.appbarku', [
        'nama'         => $nama,
        'email'        => $email,
        'link_back'    => route('admin_psikotest_kecermatan'),
        'appbar_title' => $appbar_title,
        'sidebar'      => true,
        'roles'        => $roles
    ]) @endcomponent

    <div class="p-4 text-black" style="margin-bottom: 0px;">
        <h1 class='hidden'>Halaman {{ $appbar_title }} | Admin</h1>

        <div class="">
            <form action="{{ route('admin_psikotest_kecermatan_edit', ['id' => $id]); }}" method="POST">
                @method('PUT')
                @csrf()
                <input type="hidden" id="unique" name="unique" value="{{ $unique }}" readonly />
                <h2 class="text-black">
                    <span class='font-bold'>Edit Data Kolom :</span> {{ $data['kolom_x'] }}
                </h2>

                <div>
                    <input  type="number" id="txt-nilai_A" name="nilai_A" required focused
                            placeholder="Nilai A..." label="Nilai A..." value="{{ $data['nilai_A']; }}"
                            class="w-full shadow-xl p-2 rounded-lg text-white"
                            style="background-color: rgba(0, 0, 0, 0.5)"
                    />
                    <input  type="number" id="txt-nilai_B" name="nilai_B" required focused
                            placeholder="Nilai B..." label="Nilai B..." value="{{ $data['nilai_B']; }}"
                            class="w-full mt-4 shadow-xl p-2 rounded-lg text-white"
                            style="background-color: rgba(0, 0, 0, 0.5)"
                    />
                    <input  type="number" id="txt-nilai_C" name="nilai_C" required focused
                            placeholder="Nilai C..." label="Nilai C..." value="{{ $data['nilai_C']; }}"
                            class="w-full mt-4 shadow-xl p-2 rounded-lg text-white"
                            style="background-color: rgba(0, 0, 0, 0.5)"
                    />
                    <input  type="number" id="txt-nilai_D" name="nilai_D" required focused
                            placeholder="Nilai D..." label="Nilai D..." value="{{ $data['nilai_D']; }}"
                            class="w-full mt-4 shadow-xl p-2 rounded-lg text-white"
                            style="background-color: rgba(0, 0, 0, 0.5)"
                    />
                    <input  type="number" id="txt-nilai_E" name="nilai_E" required focused
                            placeholder="Nilai E..." label="Nilai E..." value="{{ $data['nilai_E']; }}"
                            class="w-full mt-4 shadow-xl p-2 rounded-lg text-white"
                            style="background-color: rgba(0, 0, 0, 0.5)"
                    />
                </div>

                <div class="">
                    <button type="submit" class="mt-4 p-2 bg-blue-700 hover:bg-blue-500 shadow-xl text-white rounded-lg text-center w-full">
                        Simpan
                    </button>

                    <button type="button" class="mt-4 p-2 bg-pink-700 hover:bg-pink-500 shadow-xl text-white rounded-lg text-center w-full" onclick="window.location.href= `{{ route('admin_psikotest_kecermatan') }}`">
                        Kembali
                    </button>
                </div>
            </form>
        </div>
    </div>

    @component('components.footer', ['hidden' => 'hidden', 'otherCSS' => '']) @endcomponent
@endsection