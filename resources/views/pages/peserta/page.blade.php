@php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
@endphp
@extends('layouts.app')
<style>
/* untuk layar desktop */
@media (min-width: 1024px) {
    body {
        background-color: rgba(200, 200, 255, 0.9);
        background-image: url('./images/bg21.jpeg');
        background-attachment: fixed;
        font-family: Georgia, Helvetica, sans-serif;
        background-size: cover;
        background-position: center bottom;
    }
}

/* untuk layar mobile */
@media (max-width: 767px) {
    body {
        background-color: rgba(200, 200, 255, 0.9);
        background-image: url('./images/bg20.jpeg');
        background-attachment: fixed;
        font-family: Georgia, Helvetica, sans-serif;
        background-size: cover;
        background-position: center bottom;
    }
}
</style>
@section('content')
    <h1 class="hidden">Halaman Formulir Peserta Psikotest</h1>

    <div id="formpeserta">
        <div class="grid grid-rows-[20px_1fr_20px] items-center justify-items-center min-h-screen p-8 pb-20 gap-16 sm:p-20 font-[family-name:var(--font-geist-sans)]" >
            <div class="flex flex-col gap-8 row-start-2 items-center sm:items-start">
                <div class="form-entry">
                        <h2 class="text-2xl text-bold uppercase font-bold text-center text-black">Peserta</h2>
                        <div class='form_admin_peserta text-left'>
                            <input  type="text" id="nama" name ="nama" required focused
                                    placeholder="Nama..." label="Nama..."
                                    class="w-full mt-4 border-black border-2 p-2 rounded-lg text-black"
                            />
                            <input  type="number" id="no_identitas" name ="no_identitas" required focused
                                    placeholder="no_identitas..." label="no_identitas..."
                                    class="w-full mt-4 border-black border-2 p-2 rounded-lg text-black"
                            />
                            <input  type="email" id="email" name ="email" required focused
                                    placeholder="Email..." label="Email..."
                                    class="w-full mt-4 border-black border-2 p-2 rounded-lg text-black"
                            />
                            <input  type="date" id="tgl_lahir" name ="tgl_lahir" required focused
                                    placeholder="Tanggal Lahir..." label="Tanggal Lahir..."
                                    class="w-full mt-4 border-black border-2 p-2 rounded-lg text-black"
                            />
                            <input  type="text" id="asal" name ="asal" required focused
                                    placeholder="Asal..." label="Asal..."
                                    class="w-full mt-4 border-black border-2 p-2 rounded-lg text-black"
                            />
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-4 justify-self-center">
                            <button type="button" id="submit" class="p-2 bg-blue-700 hover:bg-blue-500 shadow-xl text-white rounded-lg text-center" onclick="submit()">
                                Lanjut
                            </button>

                            <button type="button" class="p-2 bg-pink-700 hover:bg-pink-500 shadow-xl text-white rounded-lg text-center" onclick="onBack()">
                                Kembali
                            </button>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <div id="formlanjut" class='hidden'>
        <div class="grid grid-rows-[20px_1fr_20px] items-center justify-items-center min-h-screen p-8 pb-20 gap-16 sm:p-20 font-[family-name:var(--font-geist-sans)]" >
            <div class="flex flex-col gap-8 row-start-2 items-center sm:items-start">
                <div class="p-3 border-2 border-black rounded-lg text-center text-white" style="background-color:rgba(0, 0, 0, 0.5)">
                    <h2 class='font-bold underline text-2lg uppercase'>Anda masih punya sesi!</h2>

                    <div class="mt-4">
                        <button type="button" class="p-2 bg-blue-700 hover:bg-blue-500 text-white rounded-lg text-center w-full" onclick="continueSession()">
                            Lanjut
                        </button>
                    </div>

                    <div class="mt-4">
                        <button type="button" class="p-2 bg-pink-700 hover:bg-pink-500 text-white rounded-lg text-center w-full" onclick="onBack()" rel="follow">
                            Kembali
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="sesiberakhir" class='hidden'>
        <div class="grid grid-rows-[20px_1fr_20px] items-center justify-items-center min-h-screen p-8 pb-20 gap-16 sm:p-20 font-[family-name:var(--font-geist-sans)]" >
            <div class="flex flex-col gap-8 row-start-2 items-center sm:items-start">
                <div class="p-3 text-center">
                    <a href="#" onclick="onBack()" rel='follow' title='Kembali'>
                        <h2 class="font-bold underline text-2lg uppercase text-black">
                            Silahkan datang esok hari lagi!
                        </h2>
                        <h3 class="underline uppercase text-black">
                            Silahkan Klik disini untuk kembali ke halaman Beranda
                        </h3>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @component('components.footer', ['hidden' => '', 'otherCSS' => 'bottom-0 w-full']) @endcomponent

    <script>
        const random = '{{ $unique; }}';
        const getDate = new Date();
        const year = getDate.getFullYear();
        const month = getDate.getMonth() + 1;
        const date = getDate.getDate();
        const today = `${year}-${month}-${date}`;

        let sesiPsikotestKecermatan = 0;
        let isSession = false;
        let tgl_tes = '';
        let datex = false;

        const textColor = localStorage.getItem('text-color');
        const textColorRGB = localStorage.getItem('text-color-rgb');
        const borderColor = localStorage.getItem('border-color-rgb');
        const borderColorRGB = localStorage.getItem('border-color-rgb');

        let nama = null;
        let no_identitas = null;
        let email = null;
        let tgl_lahir = null;
        let asal = null;

        function checkData() {
            try {
                localStorage.removeItem('csrfToken');
                sessionStorage.removeItem('peserta_id');
                sessionStorage.removeItem('psikotest_kecermatan_id');
                isSession = localStorage.getItem('sesi_psikotest_kecermatan');

                if(sessionStorage.getItem('nama_peserta_psikotest')) nama = sessionStorage.getItem('nama_peserta_psikotest');
                if(sessionStorage.getItem('no_identitas_peserta_psikotest')) no_identitas = sessionStorage.getItem('no_identitas_peserta_psikotest');
                if(sessionStorage.getItem('email_peserta_psikotest')) email = sessionStorage.getItem('email_peserta_psikotest');
                if(sessionStorage.getItem('tgl_lahir_peserta_psikotest')) tgl_lahir = sessionStorage.getItem('tgl_lahir_peserta_psikotest');
                if(sessionStorage.getItem('asal_peserta_psikotest')) asal = sessionStorage.getItem('asal_peserta_psikotest');
                if(localStorage.getItem('tgl_tes_peserta_psikotest_kecermatan')) {
                    tgl_tes = localStorage.getItem('tgl_tes_peserta_psikotest_kecermatan');
                    datex = true;
                }
                if(localStorage.getItem('sesi_psikotest_kecermatan')) {
                    sesiPsikotestKecermatan = localStorage.getItem('sesi_psikotest_kecermatan');
                    isSession = true;
                }
            }
            catch(err) {
                console.info('Terjadi Error Peserta-checkData:', err);
            }
        };

        async function submit() {
            try {
                const nama = DOMPurify.sanitize(document.getElementById('nama').value);
                const no_identitas = DOMPurify.sanitize(document.getElementById('no_identitas').value);
                const email = DOMPurify.sanitize(document.getElementById('email').value);
                const tgl_lahir = DOMPurify.sanitize(document.getElementById('tgl_lahir').value);
                const asal = DOMPurify.sanitize(document.getElementById('asal').value);
                const tgl_tes = today;

                if (!nama || !no_identitas || !tgl_lahir) {
                    alert('Nama, No Identitas, dan Tanggal Lahir harus diisi.');
                }
                else {
                    axios.defaults.withCredentials = true;
                    axios.defaults.withXSRFToken = true;
                    const response = await axios.post(`{{ route('peserta_setup') }}`, {
                        _token: '{{ csrf_token(); }}',
                        unique: '{{ $unique; }}',
                        nama: nama,
                        no_identitas: no_identitas,
                        email: email,
                        tgl_lahir: tgl_lahir,
                        asal: asal,
                        tgl_tes: tgl_tes
                    }, {
                        withCredentials: true,  // Mengirimkan cookie dalam permintaan
                        headers: {
                            'XSRF-TOKEN': '{{ csrf_token(); }}',
                            'Content-Type': 'application/json',
                            'tokenlogin': random,
                        }
                    });
                    console.info('response', response);
                    if(parseInt(response.data.success) > 0) {
                        const expires = 1;
                        const path = '{{ $path; }}';
                        const domain = '{{ $domain; }}';
                        const secure = true;
                        const sameSite = 'Strict';
                        const cookieRules = {
                            path: path,
                            domain: domain,
                            expires : expires,
                            sameSite : sameSite,
                            secure : secure,
                        };

                        Cookies.set('ispeserta', true, cookieRules);
                        sessionStorage.setItem('id_peserta_psikotest', response.data.res);
                        sessionStorage.setItem('no_identitas_peserta_psikotest', no_identitas);
                        sessionStorage.setItem('nama_peserta_psikotest', nama);
                        sessionStorage.setItem('email_peserta_psikotest', email);
                        sessionStorage.setItem('tgl_lahir_peserta_psikotest', tgl_lahir);
                        sessionStorage.setItem('asal_peserta_psikotest', asal);
                        localStorage.setItem('tgl_tes_peserta_psikotest_kecermatan', today);

                        localStorage.setItem('sesi_psikotest_kecermatan', 1);
                        sessionStorage.setItem('nilai_total_psikotest_kecermatan_kolom1', 0);
                        sessionStorage.setItem('waktupengerjaan_kolom_1', 0);
                        // window.location.href = `/public/peserta/psikotest/kecermatan/1`;
                    }
                    else if(response.data.success === 'datex') {
                        document.getElementById('formpeserta').classList.add('hidden');
                        document.getElementById('formlanjut').classList.add('hidden');
                        document.getElementById('sesiberakhir').classList.remove('hidden');
                        if(localStorage.getItem('sesi_psikotest_kecermatan') > 0 && localStorage.getItem('sesi_psikotest_kecermatan') < 6) {
                            localStorage.setItem('sesi_psikotest_kecermatan', 1);
                        }
                    }
                    else {
                        alert('Terjadi Error: Tidak Dapat Setup Data!');
                    }
                }
            }
            catch(err) {
                console.info('Terjadi Error Peserta-submit:', err);
            }
        }

        function continueSession() {
            try {
                localStorage.setItem(`sesi_psikotest_kecermatan`, 1);
                sessionStorage.setItem(`nilai_total_psikotest_kecermatan_kolom1`, 0);
                sessionStorage.removeItem(`nilai_total_psikotest_kecermatan_kolom2`);
                sessionStorage.removeItem(`nilai_total_psikotest_kecermatan_kolom3`);
                sessionStorage.removeItem(`nilai_total_psikotest_kecermatan_kolom4`);
                sessionStorage.removeItem(`nilai_total_psikotest_kecermatan_kolom5`);
                sessionStorage.setItem(`sisawaktu_pengerjaan_peserta_psikotest_kecermatan_sesi1`, 60);
                sessionStorage.removeItem(`sisawaktu_pengerjaan_peserta_psikotest_kecermatan_sesi2`);
                sessionStorage.removeItem(`sisawaktu_pengerjaan_peserta_psikotest_kecermatan_sesi3`);
                sessionStorage.removeItem(`sisawaktu_pengerjaan_peserta_psikotest_kecermatan_sesi4`);
                sessionStorage.removeItem(`sisawaktu_pengerjaan_peserta_psikotest_kecermatan_sesi5`);
                sessionStorage.setItem(`waktupengerjaan_kolom1`, 0);
                sessionStorage.removeItem(`waktupengerjaan_kolom2`);
                sessionStorage.removeItem(`waktupengerjaan_kolom3`);
                sessionStorage.removeItem(`waktupengerjaan_kolom4`);
                sessionStorage.removeItem(`waktupengerjaan_kolom5`);
                window.location.href = `/public/peserta/psikotest/kecermatan/1`;
            }
            catch(err) {
                console.info('Terjadi Error Peserta-continueSession:', err);
            }
        }

        function onBack() {
            try {
                localStorage.clear();
                sessionStorage.clear();
                // Cookies.remove('ispeserta');
                window.location.href= `{{ route('home') }}`;
            }
            catch(err) {
                console.info('Terjadi Error Peserta-onBack:', err);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            checkData();
            if(datex) {
                if (isSession) {
                    document.getElementById('formpeserta').classList.add('hidden');
                    document.getElementById('formlanjut').classList.remove('hidden');
                    document.getElementById('sesiberakhir').classList.add('hidden');
                }
                else {
                    document.getElementById('formpeserta').classList.add('hidden');
                    document.getElementById('formlanjut').classList.add('hidden');
                    document.getElementById('sesiberakhir').classList.remove('hidden');
                }
            }
            else {
                document.getElementById('formpeserta').classList.remove('hidden');
                document.getElementById('formlanjut').classList.add('hidden');
                document.getElementById('sesiberakhir').classList.add('hidden');
            }
        });
    </script>
@endsection

