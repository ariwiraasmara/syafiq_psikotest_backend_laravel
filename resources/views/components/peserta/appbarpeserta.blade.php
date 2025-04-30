@php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
@endphp
<div class="bg-black p-4 shadow-md max-w-screen fixed w-full z-50 text-white">
    <div class="container items-center">
        <h2 class='hidden'>Pertanyaan Psikotest Kecermatan <span id="kolom_x">{{ $kolom_x; }}</span></h2>
        <table class="w-full text-white border-2 border-white rounded-lg">
            <thead>
                <tr class="hidden">
                    <th colspan="5">
                        <h3>
                            Tabel Pertanyaan Psikotest Kecermatan <span id="kolom_x">{{ $kolom_x; }}</span>
                        </h3>
                    </th>
                </tr>
                <tr>
                    <th colspan="5" class="p-2 font-bold border-2 border-white text-center">
                        Kolom <span id="kolom_x">{{ $kolom_x; }}</span>
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr class="p-4 font-bold border-2 border-white text-center">
                    <th>A</th>
                    <th>B</th>
                    <th>C</th>
                    <th>D</th>
                    <th>E</th>
                </tr>
                <tr class="p-4 text-center">
                    <td>{{ $pertanyaan1; }}</td>
                    <td>{{ $pertanyaan2; }}</td>
                    <td>{{ $pertanyaan3; }}</td>
                    <td>{{ $pertanyaan4; }}</td>
                    <td>{{ $pertanyaan5; }}</td>
                </tr>
            </tbody>
        </table>
        <div class="mt-2 text-center">
            <span id="timer_tes">60 detik</span>
        </div>
    </div>
</div>