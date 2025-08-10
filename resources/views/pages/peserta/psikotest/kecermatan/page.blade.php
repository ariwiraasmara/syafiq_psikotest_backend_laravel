@php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
@endphp
@php
$nonce = request()->attributes->get('csp_nonce');
@endphp
@extends('layouts.app')
@section('content')
    @if($sessionID > 5)
        <div class="grid grid-rows-[20px_1fr_20px] items-center justify-items-center min-h-screen p-8 pb-20 gap-16 sm:p-20 font-[family-name:var(--font-geist-sans)]" >
            <div class="flex flex-col gap-8 row-start-2 items-center sm:items-start">
                <div class="p-3 text-center justify-items-center mb-6">
                    <div>
                        Tes Sudah Berakhir...<br/>
                        Harap Tunggu Sedang Menyimpan Data Ujian Anda...
                    </div>
                    <div class="loader mt-6"></div>
                </div>
            </div>
        </div>
    @else
        <div class="absolute">
            @component('components.peserta.appbarpeserta', [
                'kolom_x'     => $dataKolomPertanyaan[0]['kolom_x'],
                'pertanyaan1' => $dataKolomPertanyaan[0]['nilai_A'],
                'pertanyaan2' => $dataKolomPertanyaan[0]['nilai_B'],
                'pertanyaan3' => $dataKolomPertanyaan[0]['nilai_C'],
                'pertanyaan4' => $dataKolomPertanyaan[0]['nilai_D'],
                'pertanyaan5' => $dataKolomPertanyaan[0]['nilai_E'],
            ]) @endcomponent
        </div>

        <div class="text-center text-black" style="padding: 20px; padding-top: 170px;">
            <div class="font-bold underline text-lg text-center">Kerjakanlah Soal-Soal ini. Cocokkan dan isi yang tidak ada.</div>
            @php $no = 1; @endphp
            @foreach ($dataKecermatanSoal as $data)
                @component('components.peserta.soaljawaban', [
                    'no'           => $no,
                    'id'           => $data['id'],
                    'soal1'        => $data['soal_jawaban']['soal'][0][0],
                    'soal2'        => $data['soal_jawaban']['soal'][0][1],
                    'soal3'        => $data['soal_jawaban']['soal'][0][2],
                    'soal4'        => $data['soal_jawaban']['soal'][0][3],
                    'jawabanA'     => $dataKolomPertanyaan[0]['nilai_A'],
                    'jawabanB'     => $dataKolomPertanyaan[0]['nilai_B'],
                    'jawabanC'     => $dataKolomPertanyaan[0]['nilai_C'],
                    'jawabanD'     => $dataKolomPertanyaan[0]['nilai_D'],
                    'jawabanE'     => $dataKolomPertanyaan[0]['nilai_E'],
                    'kuncijawaban' => $data['soal_jawaban']['jawaban'],
                ]) @endcomponent
                @php $no++; @endphp
            @endforeach
        </div>

        <div class="border-t-2 border-black p-4">
            <button type="button" id="btn-next-session" class="right p-2 bg-blue-700 hover:bg-blue-500 shadow-xl text-white rounded-lg text-center w-full">
                <ion-icon name="arrow-forward-circle-outline" style="font-size: 40px; margin-top: 0px;"></ion-icon>
            </button>
        </div>
    @endif

    @component('components.footer', ['hidden' => '', 'otherCSS' => 'bottom-0 w-full']) @endcomponent

    <script nonce="{{ $nonce }}" src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous"></script>
    <script>
        const baseUrl = `{{ route('peserta_psikotest_kecermatan', ['sesi' => 'SESI']); }}`;
        const hasilUrl = `{{ route('peserta_psikotest_kecermatan_hasil', ['no_identitas' => 'NO_IDENTITAS', 'tgl_tes' => 'TGL_TES']) }}`;

        let nilaiTotal = 0;
        let jawabanUser = {};
        let timeLeft = parseInt('{{ $variabel }}');
        let sessionID = parseInt('{{ $sessionID }}') || 1;
        let interval;

        function handleChange_nilaiTotal(event, index, kuncijawaban) {
            const value = parseInt(event.target.value);
            console.info('handleChange_nilaiTotal: value', value);

            const correctAnswer = parseInt(kuncijawaban);
            console.info('handleChange_nilaiTotal: correctAnswer', correctAnswer);

            // Update jawabanUser for each change
            jawabanUser[index] = value;
            console.info('jawabanUser', jawabanUser);

            // Update nilaiTotal based on correct or incorrect answers
            if (jawabanUser[index]) { // Check if jawabanUser is already available
                if (value === correctAnswer) { // When the answer is correct
                    nilaiTotal += 1; // Increase by 1
                    sessionStorage.setItem(`nilai_total_psikotest_kecermatan_kolom${sessionID}`, nilaiTotal);
                    console.info('jawaban benar', nilaiTotal);
                } else { // When the answer is incorrect
                    if(nilaiTotal == 0) {
                        nilaiTotal += 0;
                    }
                    else {
                        nilaiTotal -= 1; // Decrease by 1
                    }
                    console.info('jawaban salah', nilaiTotal);
                }
            } else {
                if (value === correctAnswer) { // When the answer is correct
                    nilaiTotal += 1; // Increase by 1
                    console.info('jawaban benar', nilaiTotal);
                } else { // When the answer is incorrect
                    console.info('jawaban salah', nilaiTotal);
                }
            }
            sessionStorage.setItem(`nilai_total_psikotest_kecermatan_kolom${sessionID}`, nilaiTotal);
        }

        function formatTime(time) {
            const minutes = Math.floor(time / parseInt('{{ $variabel }}'));
            const seconds = time % parseInt('{{ $variabel }}');
            document.getElementById('timer_tes').innerHTML = `${minutes} menit ${seconds} detik`;
        }

        async function submit() {
            try {
                const urlStore = `{{ route('peserta_psikotest_kecermatan_store', ['id' => 'ID']) }}`;
                const id = parseInt(DOMPurify.sanitize(sessionStorage.getItem(`id_peserta_psikotest`)));
                const newUrl = urlStore.replace('ID', id);

                axios.defaults.withCredentials = true;
                axios.defaults.withXSRFToken = true;
                const response = await axios.post(newUrl, {
                    unique: '{{ $unique; }}',
                    hasilnilai_kolom_1: parseInt(DOMPurify.sanitize(sessionStorage.getItem(`nilai_total_psikotest_kecermatan_kolom1`))),
                    waktupengerjaan_kolom_1: parseInt(DOMPurify.sanitize(sessionStorage.getItem(`waktupengerjaan_kolom_1`))),
                    //
                    hasilnilai_kolom_2: parseInt(DOMPurify.sanitize(sessionStorage.getItem(`nilai_total_psikotest_kecermatan_kolom2`))),
                    waktupengerjaan_kolom_2: parseInt(DOMPurify.sanitize(sessionStorage.getItem(`waktupengerjaan_kolom_2`))),
                    //
                    hasilnilai_kolom_3: parseInt(DOMPurify.sanitize(sessionStorage.getItem(`nilai_total_psikotest_kecermatan_kolom3`))),
                    waktupengerjaan_kolom_3: parseInt(DOMPurify.sanitize(sessionStorage.getItem(`waktupengerjaan_kolom_3`))),
                    //
                    hasilnilai_kolom_4: parseInt(DOMPurify.sanitize(sessionStorage.getItem(`nilai_total_psikotest_kecermatan_kolom4`))),
                    waktupengerjaan_kolom_4: parseInt(DOMPurify.sanitize(sessionStorage.getItem(`waktupengerjaan_kolom_4`))),
                    //
                    hasilnilai_kolom_5: parseInt(DOMPurify.sanitize(sessionStorage.getItem(`nilai_total_psikotest_kecermatan_kolom5`))),
                    waktupengerjaan_kolom_5: parseInt(DOMPurify.sanitize(sessionStorage.getItem(`waktupengerjaan_kolom_5`))),
                }, {
                    withCredentials: true,  // Mengirimkan cookie dalam permintaan
                    headers: {
                        'Content-Type': 'application/json',
                        'XSRF-TOKEN': '{{ csrf_token(); }}',
                        'tokenlogin': parseInt('{{ $unique; }}'),
                    }
                });

                // console.info('response', response);
                if(parseInt(response.data.success)) {
                    localStorage.removeItem('sesi_psikotest_kecermatan');
                    setTimeout(() => {
                        const newHasilurl = hasilUrl.replace('NO_IDENTITAS', sessionStorage.getItem('no_identitas_peserta_psikotest'))
                                                    .replace('TGL_TES', localStorage.getItem('tgl_tes_peserta_psikotest_kecermatan'));
                        window.location.href = newHasilurl;
                        sessionStorage.clear();
                    }, 3000);
                }
                console.info('Tidak dapat menyimpan data sesi');
            }
            catch(err) {
                console.error('Terjadi Error PesertaPsikotestKecermatan-submit:', err);
            }
        }

        function next_session(session) {
            clearInterval(interval);
            const nextSession = parseInt(session) + 1;
            if(nextSession > 5) {
                submit();
            }
            else {
                localStorage.setItem('sesi_psikotest_kecermatan', nextSession);
                sessionStorage.setItem(`nilai_total_psikotest_kecermatan_kolom${nextSession}`, 0);
                const newUrl = baseUrl.replace('SESI', nextSession);
                window.location.href = newUrl;
            }
        }

        document.getElementById("btn-next-session").addEventListener("click", function (e) {
            e.preventDefault(); // Mencegah pengiriman form secara default
            next_session({{ $sessionID }});
        });

        document.addEventListener('DOMContentLoaded', function () {
            if (parseInt(DOMPurify.sanitize(localStorage.getItem('sesi_psikotest_kecermatan'))) > 5) {
                submit();
            } else {
                let hasUpdatedSessionID = false;
                interval = setInterval(() => {
                    timeLeft -= 1;
                    const waktupengerjaan = parseInt(60) - timeLeft;
                    if (timeLeft <= 0 && !hasUpdatedSessionID) {
                        hasUpdatedSessionID = true;
                        clearInterval(interval);
                        setTimeout(() => {
                            if (sessionID > 5) {
                                submit();
                            } else {
                                const nextSession = parseInt(sessionID) + 1;
                                localStorage.setItem('sesi_psikotest_kecermatan', nextSession);
                                sessionStorage.setItem(`nilai_total_psikotest_kecermatan_kolom${nextSession}`, 0);
                                const newUrl = baseUrl.replace('SESI', nextSession);
                                window.location.href = newUrl;
                            }
                        }, 3000);
                    }
                    formatTime(timeLeft);
                    sessionStorage.setItem(`waktupengerjaan_kolom_${sessionID}`, waktupengerjaan);
                    sessionStorage.setItem(`sisawaktu_pengerjaan_peserta_psikotest_kecermatan_sesi${sessionID}`, timeLeft);
                }, 1000); // 1000 = 1 detik, 60 detik = 60000
            }

            function handleKeydown(e) {
                if ((e.key === 'F5') || (e.ctrlKey && e.key === 'r')) {
                    e.preventDefault();
                    alert('Refresh telah dinonaktifkan!');
                }
            }

            function handleContextMenu(e) {
                e.preventDefault();
                alert('Context menu telah dinonaktifkan!');
            }

            window.addEventListener('keydown', handleKeydown);
            window.addEventListener('contextmenu', handleContextMenu);

            // Clean up function to remove event listeners
            window.onunload = function () {
                window.removeEventListener('keydown', handleKeydown);
                window.removeEventListener('contextmenu', handleContextMenu);
            };
        });
    </script>
@endsection