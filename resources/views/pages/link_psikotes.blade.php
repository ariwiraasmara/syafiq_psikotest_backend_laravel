@php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
@endphp
@extends('layouts.app')
@section('content')
    @component('components.homepage.header') @endcomponent
    @component('components.homepage.navbar', [
        'ispeserta' => $ispeserta,
        'path'      => $path,
        'domain'    => $domain
    ]) @endcomponent

    <div class="p-4 bg-kontak">
        <div class="p-4 bg-lp-white-glasses">
            <h2 class="text-2xl text-center font-bold">Link Psikotes</h2>

            <h3 class="text-2xl font-bold mt-4">Intansi dan Perusahaan</h3>

            <p>
                <ol class="list-alpha ml-6">
                    <li><span class="font-bold">Intansi Pemerintah</span>
                        <ul class="list-decimal ml-6">
                            <li>POLDA Banten</li>
                            <li>BKD Kota Serang</li>
                            <li>Disnaker Provinsi Banten</li>
                            <li>Kementerian Koperasi</li>
                            <li><a href="#asesmen-psikologi-pegawai-berhak/" target="_blank" rel="follow" class="text-blue-800 hover:text-blue-500">Direktorat Metrologi Kementerian Perdagangan Republik Indonesia</a></li>
                        </ul>
                    </li>
                    <li><span class="font-bold">Perusahaan</span>
                        <ul class="list-decimal ml-6">
                            <li>PT. Surya Donasin</li>
                            <li>PT. Pigeon</li>
                            <li>PT. Suri Tani</li>
                            <li>PT. Sanbe Farma</li>
                            <li>PT. Inti Everspring Indonesia</li>
                            <li>PT. Kimia Kayaku</li>
                            <li>Bank Bukopin</li>
                            <li>Bank BTN</li>
                        </ul>
                    </li>
                    <li><span class="font-bold">SMA</span>
                        <ul class="list-decimal ml-6">
                            <li>Link Utama</li>
                            <li>Link Cadangan</li>
                        </ul>
                    </li>
                    <li><span class="font-bold">Sekolah Tinggi / Universitas</span>
                        <ul class="list-decimal ml-6">
                            <li>Link Utama</li>
                            <li>Link Alternatif</li>
                        </ul>
                    </li>
                    <li><span class="font-bold">Umum</span>
                        <ul class="list-decimal ml-6">
                            <li>Link Utama
                                <ol class="list-disc ml-6">
                                    <li><a href="https://forms.gle/uWsfKXqFQGg2PGh88" target="_blank" rel="noreferrer noopener" class="text-blue-800 hover:text-blue-500">https://forms.gle/uWsfKXqFQGg2PGh88</a></li>
                                </ol>
                            </li>
                            <li>Link Cadangan</li>
                        </ul>
                    </li>
                </ol>
            </p>
        </div>
    </div>

    @component('components.footer', ['hidden' => '', 'otherCSS' => '']) @endcomponent
@endsection
