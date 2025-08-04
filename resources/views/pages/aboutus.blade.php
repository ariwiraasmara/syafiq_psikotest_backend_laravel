@php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
@endphp
@extends('layouts.app')
@section('content')
    @component('components.homepage.header') @endcomponent
    @component('components.homepage.navbar', [
        'ispeserta' => $ispeserta,
        'path'      => $path,
        'domain'    => $domain
    ]) @endcomponent

    <div class="p-4 bg-aboutus">
        <div class="p-4 bg-lp-white-glasses">
            <h2 class="text-center text-2xl font-bold underline">Mengenai Kami</h2>
            <div class="mt-4 md:flex md:flex-row">
                <div class="md:mb-2">
                    <div class="p-2 mb-4 justify-items-center items-center">
                        <picture class="block text-center">
                            <source srcset="{{ asset('images/Syafiq_Marzuki.webp') }}" type="image/webp" />
                            <img src="{{ asset('images/Syafiq_Marzuki.png') }}" loading="lazy" width="300" height="300" class="border-2 border-black rounded-full shadow-xl" title="Syafiq Marzuki, Psikolog" alt="Syafiq Marzuki, Psikolog" />
                        </picture>
                    </div>
                    <div class="p-2 mb-4 justify-items-center items-center">
                        <picture class="block text-center">
                            <source srcset="{{ asset('images/HPI.webp') }}" type="image/webp" />
                            <img src="{{ asset('images/HPI.png') }}" loading="lazy" width="300" height="300" class="border-2 border-black shadow-xl" width="200" height="350" title="HPI" alt="HPI" />
                        </picture>
                    </div>
                </div>
                <div class="md:p-4">
                    <p class="mt-4">
                        <strong>LPT SOLUSI Banten</strong> adalah Lembaga Psikologi Terapan yang sudah terpercaya dan terkenal sejak tahun 2006. Lokasi Kantor dan Klinik Pelayanan Lembaga Psikologi ini berlokasi di Kota Serang Banten.
                    </p>
                    <p class="mt-4">
                        <strong>LPT SOLUSI Banten</strong> di dukung oleh Psikolog yang dilengkapi SIPP dari HIMPSI dan beberapa telah memiliki sertifikat dari BNSP RI. Selain itu juga di bantu oleh Assisten Psikolog serta tenaga ahli berpengalaman dalam bidang psikologi dan human resource management. Saat ini LPT SOLUSI bermitra dengan beberapa Lembaga atau Biro Konsultasi Psikologi lainnya maupun Rumah Sakit yang ada di Banten untuk kasus tertentu.
                    </p>
                    <p class="mt-4">
                        <strong>LPT SOLUSI Banten</strong> telah banyak menangani konseling individual, konseling kelompok, konseling perkawinan, konseling industri, psikotest pendidikan, psikotest industri, workshop, seminar, parenting, outbound, pendampingan individual dan berbagai jenis terapi hingga terapi tumbuh kembang.
                    </p>
                    <p class="mt-4">
                        <strong>LPT SOLUSI Banten</strong> memiliki kantor pusat di Kota Serang Banten, kantor cabang di Depok Jakarta Selatan dan kantor cabang operasional yang ada di kota Serang sendiri.
                    </p>
                </div>
            </div>
        </div>
    </div>

    @component('components.footer', ['hidden' => '', 'otherCSS' => '']) @endcomponent
@endsection
