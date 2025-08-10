@php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
@endphp
@extends('layouts.app')
@section('content')
    @component('components.appbarku', [
        'appbar_title' => $appbar_title,
        'link_back'    => route('home'),
        'roles'        => 0
    ]) @endcomponent

    <div class="p-4 text-black">
        <h2 class='hidden'>Halaman Hasil Psikotest Kecermatan Peserta {{ $data['peserta'][0]['nama']; }}</h2>
        <div>
            <h3 class="font-bold underline text-lg">Profil Peserta</h3>
            <p><span class="font-bold">Nama :</span> {{ $data['peserta'][0]['nama']; }}</p>
            <p><span class="font-bold">No. Identitas :</span> {{ $no_identitas; }}</p>
            <p><span class="font-bold">Email :</span> {{ $data['peserta'][0]['email']; }}</p>
            <p><span class="font-bold">Tanggal Lahir :</span> {{ $data['peserta'][0]['tgl_lahir']; }}</p>
            <p><span class="font-bold">Usia :</span> {{ $data['peserta'][0]['usia']; }}</p>
            <p><span class="font-bold">Asal : </span> {{ $data['peserta'][0]['asal']; }}</p>
            <p><span class="font-bold">Tanggal Tes : </span> {{ $tgl_tes }}</p>
        </div>

        <div class="mt-4 p-2">
            <h3 class='hidden'>Peserta : [dataPeserta.nama]</h3>
            @component('components.peserta.tabelhasilpsikotestkecermatan', [
                'hasil_kolom1' => $data['hasiltes'][0]['hasilnilai_kolom_1'],
                'waktu_kolom1' => $data['hasiltes'][0]['waktupengerjaan_kolom_1'],
                'hasil_kolom2' => $data['hasiltes'][0]['hasilnilai_kolom_2'],
                'waktu_kolom2' => $data['hasiltes'][0]['waktupengerjaan_kolom_2'],
                'hasil_kolom3' => $data['hasiltes'][0]['hasilnilai_kolom_3'],
                'waktu_kolom3' => $data['hasiltes'][0]['waktupengerjaan_kolom_3'],
                'hasil_kolom4' => $data['hasiltes'][0]['hasilnilai_kolom_4'],
                'waktu_kolom4' => $data['hasiltes'][0]['waktupengerjaan_kolom_4'],
                'hasil_kolom5' => $data['hasiltes'][0]['hasilnilai_kolom_5'],
                'waktu_kolom5' => $data['hasiltes'][0]['waktupengerjaan_kolom_5'],
            ]) @endcomponent

            @component('components.peserta.grafikhasilpsikotestkecermatan', [
                'hasil_kolom1' => $data['hasiltes'][0]['hasilnilai_kolom_1'],
                'waktu_kolom1' => $data['hasiltes'][0]['waktupengerjaan_kolom_1'],
                'hasil_kolom2' => $data['hasiltes'][0]['hasilnilai_kolom_2'],
                'waktu_kolom2' => $data['hasiltes'][0]['waktupengerjaan_kolom_2'],
                'hasil_kolom3' => $data['hasiltes'][0]['hasilnilai_kolom_3'],
                'waktu_kolom3' => $data['hasiltes'][0]['waktupengerjaan_kolom_3'],
                'hasil_kolom4' => $data['hasiltes'][0]['hasilnilai_kolom_4'],
                'waktu_kolom4' => $data['hasiltes'][0]['waktupengerjaan_kolom_4'],
                'hasil_kolom5' => $data['hasiltes'][0]['hasilnilai_kolom_5'],
                'waktu_kolom5' => $data['hasiltes'][0]['waktupengerjaan_kolom_5'],
                'tgl_ujian'    => $tgl_tes
            ]) @endcomponent
        </div>
    </div>

    @component('components.footer', ['hidden' => '', 'otherCSS' => 'bottom-0 w-full']) @endcomponent
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            sessionStorage.clear();
        })
    </script>
@endsection