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

    <div class="p-4 bg-artikel">
        <div class="p-4 bg-lp-white-glasses">
            <h2 class="text-center text-2xl font-bold underline">Artikel</h2>
            <div class="mt-4">
                <div class="p-2 mb-4 flex flex-col items-center justify-center text-center">
                    <picture class="block text-center">
                        <source srcset="{{ asset('images/album/Psikotes-Masal-2.webp') }}" type="image/webp" />
                        <img src="{{ asset('images/album/Psikotes-Masal-2.png') }}" loading="lazy" width="300" height="300" class="border-2 border-black rounded-full shadow-xl" title="Syafiq Marzuki, Psikolog" alt="Syafiq Marzuki, Psikolog" />
                    </picture>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-center text-lg font-bold">Tujuan dan Manfaat Tes Psikologi</h3>
                <p class="mt-4">
                    <a href="http://www.konsultanpsikologijakarta.com/software-ist/" class="text-blue-700">Tes Psikologi</a> sebagai salah satu Metode dari Psikodiagnostik, mempunyai tujuan untuk mengadakan Klasifikasi, Deskripsi, Interpretasi dan Prediksi. Klasifikasi bertujuan untuk membantu mengatasi problem-problem yang berhubungan dengan:

                    <ol class="ml-6 list-decimal">
                        <li>Pendidikan, menyangkut masalah intelegensi, minat dan bakat, kesukaran belajar dan sebagainya. Tes intelegensi bertujuan un-tuk mengetahui tingkat kecerdasan individu yang merupa kan potensi dasar keberhasilan pendidikan. Tes Minat bakat bertujuan membantu individu menyesuaikan jurusan atau ekstra kurikuler dalam pendidikan sehingga bakat dan potensinya da pat diaktualkan secara optimal. Kesukaran belajar atau ketidakmampuan dalam belajar/Learning Disability (LD).</li>
                        <li>Perkembangan Anak, menyangkut hambatan-hambatan perkembangan baik psikis maupun sosial.</li>
                        <li>Klinis, berhubungan dengan individu-individu yang mengalami gangguan-gangguan psikis, baik yang ringan maupun yang berat.</li>
                        <li>Industri, berhubungan dengan seleksi karyawan, evaluasi dan promosi, seperti berikut ini :
                            <ul class="ml-6 list-disc">
                                <li>Seleksi : suatu proses pemilihan individu yang dinilai paling sesuai untuk menduduki jabatan atau posisi tertentu dalam perusahaan.</li>
                                <li>Evaluasi : pemeriksaan psikologis yang ber-tujuan untuk membantu perusahaan menilai apakah posisi yang ditempati saat ini telah sesuai dengan kemampuan yang dimiliki karyawan yang bersangkutan.</li>
                                <li>Promosi : pemeriksaan psikologis yang bertujuan untuk menilai kemampuan seseorang apakah telah memenuhi syarat untuk dapat menduduki jabatan atau posisi yang lebih tinggi dalam perusahaan. Pemeriksaan psikologis secara garis besar dapat diklasifikasikan sebagai berikut:
                                    <ul class="ml-6 list-disc">
                                        <li>Level Staff (Non-Manajerial), aspek-aspek yang perlu dan dapat diungkap mencakup kemampuan umum (Intelegensi), kesesuaian kepribadian, sikap dan kemampuan bekerja dalam menghadapi persoalan praktis sehari-hari.</li>
                                        <li>Level Supervisor, aspek-aspek yang perlu dan dapat diungkap mencakup kemampuan umum (Intelegensi), kesesuaian kepribadian, sikap dan kemampuan kerja, gaya kepemimpinan dan pengambilan keputusan.</li>
                                        <li>Level Manajerial, aspek-aspek yang perlu dan dapat diungkap mencakup kemampuan umum (Intelegensi), pengambilan keputusan dan kemampuan pemecahan masalah secara strategis, gaya kepemimpinan, kepribadian, hubungan interpersonal dan sikap kerja.</li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ol>
                </p>
                <p class="mt-4">
                    Alat-alat Tes tidak hanya digunakan untuk klasifikasi gangguan-gangguan psikis atau diagnosa, tetapi lebih tertuju pada pendeskripsian atau pemahaman yang lebih intensif (mendalam) dari subyek. Karena tingkah laku individu (kepribadiannya) dipandang sebagai produk dari aspek-aspek sosiobiopsikologis, maka pemeriksaan psikologis bertujuan untuk memperoleh deskripsi keseluruhan mengenai individu dan ketiga aspek tersebut. Tes psi kologi di sam ping mempunyai tujuan yang sudah tersebut di atas juga mempunyai tujuan prediksi yakni untuk meramalkan atau memprediksikan perkembangan klien selanjutnya.
                </p>
            </div>
        </div>
    </div>

    @component('components.footer', ['hidden' => '', 'otherCSS' => '']) @endcomponent
@endsection
