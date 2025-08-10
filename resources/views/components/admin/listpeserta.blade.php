@php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
    use App\Libraries\myfunction;
@endphp
@if($listpeserta)
    @foreach($listpeserta as $data)
        <a href="{{ route('admin_peserta_detil', ['tgl1' => '-', 'tgl2' => '-', 'id' => myfunction::enval($data['id'], true)]); }}" class="" title="{{ 'Detil Peserta '.$data['nama'] }}" rel="follow">
            <h3 class="p-3 mt-2 mb-4 bg-slate-50 border-b-2 border-black rounded-t-md text-black shadow-xl">
                @if($islatest)
                    <p><span class="font-bold">{{ 'Tanggal Terakhir Ujian : '.$data['tgl_ujian'] }}</span></p>
                @endif
                <p><span class="font-bold">{{ $data['nama'] }}</span></p>
                <p>{{ $data['no_identitas'] }}</p>
                <p>{{ $data['email'] }}</p>
                <p>{{ $data['asal'] }}</p>
            </h3>
        </a>
    @endforeach
@else
<div class="mt-2">
        <div class="p-4 bg-white text-center text-black text-xl shadow-xl">
            Belum Ada Data Peserta!
        </div>
    </div>
@endif