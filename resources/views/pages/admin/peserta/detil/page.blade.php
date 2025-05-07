{{--
! Copyright @
! Syafiq
! Syahri Ramadhan Wiraasmara (ARI)
--}}
@php
    use App\Libraries\myfunction;
@endphp
@extends('layouts.app')
@section('content')
    @component('components.appbarku', [
        'nama'         => $nama,
        'link_back'    => route('admin_peserta', ['sort' => 'nama', 'by' => 'asc', 'search' => '-']).'?page=1',
        'appbar_title' => $appbar_title,
    ]) @endcomponent

    <div class="p-4 text-black" style="margin-bottom: 10px; ">
        <h1 class='hidden'>Halaman {{ $appbar_title }} | Admin</h1>
        <div>
            <p>
                <span class='mr-4' style="font-size: 20px;">
                    <a href="{{ route('admin_peserta_edit', ['id' => $id]); }}" rel="nofollow" title="Edit Data Peserta {{ $dataprofil['nama'] }}">
                        <ion-icon name="pencil-outline"></ion-icon>
                    </a>
                </span>
                <span class="font-bold">Nama :</span> {{ $dataprofil['nama'] }}
            </p>
            <p><span class="font-bold">No. Identitas :</span> {{ $dataprofil['no_identitas'] }}</p>
            <p><span class="font-bold">Email :</span> {{ $dataprofil['email'] }}</p>
            <p><span class="font-bold">Tanggal Lahir :</span> {{ $dataprofil['tgl_lahir'] }}</p>
            <p><span class="font-bold">Usia :</span> {{ $dataprofil['usia'] }}</p>
            <p><span class="font-bold">Asal : </span> {{ $dataprofil['asal'] }}</p>
        </div>

        <div class="mt-4">
            <div class="text-right">
                <button type="button" id="btn-info" class="bg-blue-700 rounded-lg text-white" onclick="showModal()" style="heigth: 25px; width: 50px; font-size: 20px; padding-top: 7px;">
                    <ion-icon name="information-circle-outline"></ion-icon>
                </button>
            </div>

            <div class="p-4 rounded-lg mb-4 bg-white border-2 border-black w-full" style="overflow-x: auto;">
                <div class='font-bold'>
                    <h2 class='font-bold ml-2'>Cari Data...</h2>
                </div>
                <div class='static grid grid-cols-2 gap-2 mt-2'>
                    <div class="w-full">
                        <input type='date' id="date-waktufrom" name="date_waktufrom" value="{{ $tgl1; }}" class="w-full border-2 border-black rounded-lg p-2 text-white" style="background-color: rgba(0,0,0,0.5)" />
                    </div>
                    <div class="w-full">
                        <input type='date' id="date-waktuto" name="date_waktuto" value="{{ $tgl2; }}" class="w-full border-2 border-black rounded-lg p-2 text-white" style="background-color: rgba(0,0,0,0.5)" />
                    </div>
                </div>
                <div class='static grid grid-cols-2 gap-2 mt-2'>
                    <div class='w-full'>
                        <button type="button" title='Batal Pencarian Data dan Refresh Data' class="w-full rounded-lg p-2 text-black text-lg font-bold" style="background-color: #5f5" onclick="cancelSearch()">
                            <ion-icon name="refresh-outline"></ion-icon>
                        </button>
                    </div>
                    <div class="w-full">
                        <button type="button" title='Cari Data' class="w-full rounded-lg p-2 text-white text-lg" style="background-color: #55f" onclick="getData()">
                            <ion-icon name="search-outline"></ion-icon>
                        </button>
                    </div>
                </div>
            </div>

            @component('components.admin.peserta.tabdatahasilpsikotestpesertadetil', [
                'unique'     => $unique,
                'peserta_id' => myfunction::enval($dataprofil['id'], true),
                'hasiltes'   => $hasiltes
            ]) @endcomponent
        </div>
    </div>

    <div id="myModal" class="fixed inset-0 hidden items-center justify-items-center min-h-screen p-8 pb-20 gap-16 sm:p-19" onclick="hideModal()">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" style="height: 100%; overflow-y: scroll; overflow-x: scroll;">
            <h3 class="text-2xl font-bold text-black text-center underline mt-2">Informasi</h3>
            <div class="mt-3 text-center">
                <div class="mt-2 px-7 py-3">
                    <div class="text-black text-left">
                        <p style="padding: 10px; ">Ikon pensil disamping nama peserta merujuk ke halaman edit data peserta</p>
                        
                        <p style="padding: 10px; margin-top: 10px; border-top: 2px solid #000;">Tombol <b>"Batal & Refresh <ion-icon name="search-outline"></ion-icon>"</b> berfungsi sebagai untuk membatalkan hasil pencarian dan mengembalikan tampilan data ke awal.</p>
                        
                        <p style="padding: 10px; margin-top: 10px; border-top: 2px solid #000;">
                            Terdapat 2 kotak untuk mengisi variabel tanggal.<br/><br/>
                            Pada tab <b>"Tabel"</b> kemudian memilih salah satu jenis psikotest,
                            dapat digunakan untuk mendapatkan 1 data dengan cara menyamakan data tanggal pada 2 field, sebagai contoh : <u>"01-01-2024"</u> dan <u>"01-01-2024"</u>.<br/><br/>
                            Sedangkan pada tab <b>"Grafik"</b>, tidak dapat mendapatkan 1 data, dikarenakan hasil akhir pada grafik hanya akan menampilkan titik saja, tidak ada garis yang menghubungkan antara 2 variabel tanggal yang yang dipilih dan menghubungkan.    
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="items-center">
            <button type="button" id="closeModal" onclick="hideModal()" class="rounded-lg p-2 text-white" style="background-color: rgba(50, 50, 255, 0.9)">
                Tutup
            </button>
        </div>
    </div>

    @component('components.footer', ['hidden' => 'hidden', 'otherCSS' => '']) @endcomponent

    <script>
        function showModal() {
            document.getElementById('myModal').classList.remove('hidden');
        }

        function hideModal() {
            document.getElementById('myModal').classList.add('hidden');
        }

        // document.getElementById('closeModal').addEventListener('click', hideModal);

        function getData() {
            const tgl1 = document.getElementById('date-waktufrom').value;
            const tgl2 = document.getElementById('date-waktuto').value;
            window.location.href = `/public/admin/peserta-detil/${tgl1}/${tgl2}/{{ myfunction::enval($dataprofil['id'], true); }}`;
        }

        function cancelSearch() {
            document.getElementById('date-waktufrom').value = null;
            document.getElementById('date-waktuto').value = null;
            window.location.href = `/public/admin/peserta-detil/-/-/{{ myfunction::enval($dataprofil['id'], true); }}`;
        }
    </script>
@endsection