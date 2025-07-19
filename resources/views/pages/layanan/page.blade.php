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

    <div class="p-4 bg-kontak">
        <div class="p-4 bg-lp-white-glasses">
            <h2 class="text-2xl text-center font-bold">Layanan</h2>

            <div class="mt-6">
                <img src="{{ asset('images/bg5.jpg') }}" alt="Gambar 1" title="Gambar 1" class="shadow-xl" />
            </div>

            <div class="mt-6">
                <h3 class="text-2xl font-bold">Psikotes Pembuatan SIM (Surat Izin Mengemudi)</h3>
                <p clas="mt-4">
                    LPT SOLUSI merupakan partner kepolisian Daerah Banten (POLDA Banten) dalam Psikotes Pembuatan dan perpanjangan SIM, Khususnya di Wilayah POLDA Banten.
                </p>
            </div>

            <div class="mt-6">
                <h3 class="text-2xl font-bold">Psikologi Pendidikan dan Sekolah</h3>
                <p clas="mt-4">
                    Tes Inteligensi, Tes Kesiapan Masuk SD, Tes Gaya Belajar, Tes Minat, Tes Bakat, Tes IQ, Tes Kepribadian, Deteksi Gangguan Belajar, Tes Kematangan Emosional, Tes Kematangan Sosial, Penjurusan, Kelanjutan Studi, Terapis ABK, Guru Pendamping, Mapping guru.
                </p>
            </div>

            <div class="mt-6">
                <h3 class="text-2xl font-bold">Psikologi Industri Organisasi</h3>
                <p clas="mt-4">
                    Psikotes Rekruitmen Karyawan, Psikotes Evaluasi Kerja, Psikotes Promosi Jabatan, Psikotes Penilaian Kerja, Interview, FGD / LGD, Diklat, training, dan pengembangan diri.
                </p>
                <div class="flex flex-row mt-4">
                    <div class="basis-1/2 mx-6">
                        <img src="{{ asset('images/album/IMG-20211002-WA0019.jpg') }}" class="shadow-xl"  />
                        <div class="text-center text-white" style="margin-top: -30px">Kerjasama dengan HRD Perusahaan</div>
                    </div>
                    <div class="basis-1/2 mx-6">
                        <img src="{{ asset('images/album/IMG-20211130-WA0016.jpg') }}" class="shadow-xl"  />
                        <div class="text-center text-white" style="margin-top: -30px">Pengarahan Pra Psikotes</div>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-2xl font-bold">Psikoterapi</h3>
                <p clas="mt-4">
                    Hipnoterapi, Relaksasi, Creative Trauma Cleansing (CTC), Psychosexual Therapy, Neuro Linguistic Programming (NLP), Sensory Integration Therapy, Occupational Therapy, Speech Therapy, Snoezlen, Hydro Therapy, Physiotherapy, Cognitive Behaviour Therapy, Couples Therapy, Family / Systemic Therapy, Terapi anak berkebutuhan Khusus dan Terapi Tumbuh Kembang Anak.
                </p>
            </div>

            <div class="mt-6">
                <h3 class="text-2xl font-bold">Konsultasi Psikologi</h3>
                <p clas="mt-4">
                    Konsultasi Individu, Konseling Keluarga, Konsultasi Pernikahan, Konsultasi Percintaan, Konsultasi Anak, Konsultasi Karir dan Konsultasi Bisnis.
                </p>
            </div>

            <div class="mt-6">
                <h3 class="text-2xl font-bold">Menyediakan peralatan dan media terapi anak</h3>
                <p clas="mt-4">
                    Selain jasa layanan-layanan di atas, kami juga menyediakan berbagai macam permainan edukasi anak, yang biasa digunakan sebagai media terapi tumbuh kembang anak.
                </p>
            </div>
        </div>
    </div>

    @component('components.footer', ['hidden' => '', 'otherCSS' => '']) @endcomponent
@endsection
