@php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
@endphp
<div class="p-4 mt-4 rounded-lg mb-4 bg-white border-2 border-black">
    <h2 class="font-bold underline text-black text-center">Tabel Kecermatan Psikotest</h2>

    <div style="width: 100%; overflow-x: scroll;">
        <table class="border-spacing-2 table-auto mt-6" style="width: 100%; overflow-x: scroll;">
            <thead>
                <tr class="border-b-2" style="overflow-x: auto; border-bottom: 2px solid #000">
                    <th rowspan="2" class="p-2" style="width: 20%; border-bottom: 2px solid #000; border-right: 2px solid #000;">Tanggal</th>
                    <th colspan="5" class="p-2" style="width: 40%; border-bottom: 2px solid #000; border-right: 2px solid #000;">Hasil</th>
                    <th colspan="5" class="p-2" style="width: 40%; border-bottom: 2px solid #000; border-right: 2px solid #000;">Waktu</th>
                </tr>
                <tr>
                    <th style="width: 8%; background: #f00; border-bottom: 2px solid #000;">1</th>
                    <th style="width: 8%; background: #0f0; border-bottom: 2px solid #000;">2</th>
                    <th style="width: 8%; background: #00f; border-bottom: 2px solid #000;">3</th>
                    <th style="width: 8%; background: #ff0; border-bottom: 2px solid #000;">4</th>
                    <th style="width: 8%; background: #0ff; border-bottom: 2px solid #000; border-right: 2px solid #000;">5</th>
                    <th style="width: 8%; background: #f00; border-bottom: 2px solid #000;">1</th>
                    <th style="width: 8%; background: #0f0; border-bottom: 2px solid #000;">2</th>
                    <th style="width: 8%; background: #00f; border-bottom: 2px solid #000;">3</th>
                    <th style="width: 8%; background: #ff0; border-bottom: 2px solid #000;">4</th>
                    <th style="width: 8%; background: #0ff; border-bottom: 2px solid #000; border-right: 2px solid #000;">5</th>
                </tr>
            </thead>
            <tbody id="tabeldetil-content">
                @if($hasiltes->isEmpty())
                    <tr>
                        <td colspan="11" class="text-center p-2">
                            <h3 class="text-2xl font-bold">
                                Cari Datanya Dulu...
                            </h3>
                        </td>
                    </tr>
                @else
                    @foreach($hasiltes as $data)
                        <tr>
                            <td class="text-center p-2" style="border-bottom: 2px solid #000; border-right: 2px solid #000;">{{ $data['tgl_ujian']; }}</td>
                            <td class="text-center p-2" style="width: 8%; background: #f00; border-bottom: 2px solid #000;">{{ $data['hasilnilai_kolom_1']; }}</td>
                            <td class="text-center p-2" style="width: 8%; background: #0f0; border-bottom: 2px solid #000;">{{ $data['hasilnilai_kolom_2']; }}</td>
                            <td class="text-center p-2" style="width: 8%; background: #00f; border-bottom: 2px solid #000;">{{ $data['hasilnilai_kolom_3']; }}</td>
                            <td class="text-center p-2" style="width: 8%; background: #ff0; border-bottom: 2px solid #000;">{{ $data['hasilnilai_kolom_4']; }}</td>
                            <td class="text-center p-2" style="width: 8%; background: #0ff; border-bottom: 2px solid #000; border-right: 2px solid #000;">{{ $data['hasilnilai_kolom_5']; }}</td>
                            <td class="text-center p-2" style="width: 8%; background: #f00; border-bottom: 2px solid #000;">{{ $data['waktupengerjaan_kolom_1']; }}</td>
                            <td class="text-center p-2" style="width: 8%; background: #0f0; border-bottom: 2px solid #000;">{{ $data['waktupengerjaan_kolom_2']; }}</td>
                            <td class="text-center p-2" style="width: 8%; background: #00f; border-bottom: 2px solid #000;">{{ $data['waktupengerjaan_kolom_3']; }}</td>
                            <td class="text-center p-2" style="width: 8%; background: #ff0; border-bottom: 2px solid #000;">{{ $data['waktupengerjaan_kolom_4']; }}</td>
                            <td class="text-center p-2" style="width: 8%; background: #0ff; border-bottom: 2px solid #000; border-right: 2px solid #000;">{{ $data['waktupengerjaan_kolom_5']; }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>