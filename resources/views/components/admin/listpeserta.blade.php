@php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
    use App\Libraries\myfunction;
@endphp
@if($listpeserta)
    @foreach($listpeserta as $data)
        <a href="{{ route('admin_peserta_detil', ['tgl1' => '-', 'tgl2' => '-', 'id' => myfunction::enval($data['id'], true)]); }}" class="" title="{{ 'Detil Peserta '.$data['nama'] }}" rel="follow">
            <h3 class="bg-slate-50 border-b-2 p-3 rounded-t-md mt-2 text-black border-black">
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
    <h2 class="font-bold text-center text-lg text-black">
        Data Peserta Kosong!<br/>Belum Ada Data!
    </h2>
@endif