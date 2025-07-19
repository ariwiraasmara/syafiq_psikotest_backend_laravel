@php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
@endphp
<div class="rounded-lg bg-white border-2 border-black" style="overflow-x: auto;">
    <table class="border-spacing-2 table-auto w-full overflow-x-auto md:overscroll-contain">
        <thead class="border-spacing-2 table-auto w-full">
            <tr>
                <th colspan="6" class="p-4">
                    <h4 className='font-bold text-black text-xl'>
                        Tabel Hasil Psikotest Kecermatan
                    </h4>
                </th>
            </tr>
            <tr class="mt-2 overscroll-auto">
                <th class="border-b-2 border-gray-200 p-2"></th>
                <th class="text-center border-gray-200 border-b-2 p-2">Kolom 1</th>
                <th class="text-center border-gray-200 border-b-2 p-2">Kolom 2</th>
                <th class="text-center border-gray-200 border-b-2 p-2">Kolom 3</th>
                <th class="text-center border-gray-200 border-b-2 p-2">Kolom 4</th>
                <th class="text-center border-gray-200 border-b-2 p-2">Kolom 5</th>
            </tr>
        </thead>
    
        <tbody class="">
            <tr>
                <td class="border-b-2 border-gray-200 p-2">Hasil</td>
                <td class="text-center border-b-2 border-gray-200 p-2">{{ $hasil_kolom1; }}</td>
                <td class="text-center border-b-2 border-gray-200 p-2">{{ $hasil_kolom2; }}</td>
                <td class="text-center border-b-2 border-gray-200 p-2">{{ $hasil_kolom3; }}</td>
                <td class="text-center border-b-2 border-gray-200 p-2">{{ $hasil_kolom4; }}</td>
                <td class="text-center border-b-2 border-gray-200 p-2">{{ $hasil_kolom5; }}</td>
            </tr>
            <tr>
                <td class="p-2">Lama Pengerjaan</td>
                <td class="text-center p-2">{{ $waktu_kolom1; }} detik</td>
                <td class="text-center p-2">{{ $waktu_kolom2; }} detik</td>
                <td class="text-center p-2">{{ $waktu_kolom3; }} detik</td>
                <td class="text-center p-2">{{ $waktu_kolom4; }} detik</td>
                <td class="text-center p-2">{{ $waktu_kolom5; }} detik</td>
            </tr>
        </tbody>
    </table>
</div>
