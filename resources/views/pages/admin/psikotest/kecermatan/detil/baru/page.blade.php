{{--
! Copyright @
! Syafiq
! Syahri Ramadhan Wiraasmara (ARI)
--}}
@extends('layouts.app')
@section('content')
    @component('components.appbarku', [
        'nama'         => $nama,
        'link_back'    => '/admin/psikotest/kecermatan/detil/1',
        'appbar_title' => $appbar_title,
    ]) @endcomponent

    <div class="p-4 text-black" style="margin-bottom: 0px;">
        <h1 class='hidden'>Halaman {{ $appbar_title }} | Admin</h1>

        <div class="">
            <form action="{{ '/admin/psikotest/kecermatan/detil-baru/'.$id }}" method="POST">
                @csrf()
                <input type="hidden" id="unique" name="unique" value="{{ $unique }}" readonly />

                <input  type="number" id="txt-soalA" name="soalA" required focused
                        placeholder="Soal A..." label="Soal A..."
                        class="w-full mt-4 border-white border-2 p-2 rounded-lg text-white"
                        style="background-color: rgba(0, 0, 0, 0.5)"
                />

                <input  type="number" id="txt-soalB" name="soalB" required focused
                        placeholder="Soal B..." label="Soal B..."
                        class="w-full mt-4 border-white border-2 p-2 rounded-lg text-white"
                        style="background-color: rgba(0, 0, 0, 0.5)"
                />

                <input  type="number" id="txt-soalC" name="soalC" required focused
                        placeholder="Soal C..." label="Soal C..."
                        class="w-full mt-4 border-white border-2 p-2 rounded-lg text-white"
                        style="background-color: rgba(0, 0, 0, 0.5)"
                />

                <input  type="number" id="txt-soalD" name="soalD" required focused
                        placeholder="Soal D..." label="Soal D..."
                        class="w-full mt-4 border-white border-2 p-2 rounded-lg text-white"
                        style="background-color: rgba(0, 0, 0, 0.5)"
                />

                <input  type="number" id="txt-jawaban" name="jawaban" required focused
                        placeholder="Jawaban..." label="Jawaban..."
                        class="w-full mt-4 border-white border-2 p-2 rounded-lg text-white"
                        style="background-color: rgba(0, 0, 0, 0.5)"
                />

                <div class="">
                    <button type="submit" class="mt-4 p-2 border-2 border-white bg-blue-700 hover:bg-blue-500 text-white rounded-lg text-center w-full">
                        Simpan
                    </button>

                    <button type="button" class="mt-4 p-2 border-2 border-white bg-pink-700 hover:bg-pink-500 text-white rounded-lg text-center w-full" onclick="window.location.href = '/admin/variabel'">
                        Kembali
                    </button>
                </div>

                @if(session('error'))
                    <div class="bg-red-700 text-white text-center uppercase mt-4 rounded-lg p-4">
                        Terjadi Kesalahan! <br/>
                        Tidak dapat menyimpan data!
                    </div>
                @endif
            </form>
        </div>
    </div>

    @component('components.footer', ['hidden' => 'hidden', 'otherCSS' => '']) @endcomponent
@endsection