{{--
! Copyright @
! PT. Solusi Psikologi Banten
! Syafiq Marzuki
! Syahri Ramadhan Wiraasmara (ARI)
--}}
@extends('layouts.app')
@section('content')
    @component('components.appbarku', [
        'nama'         => $nama,
        'email'        => $email,
        'link_back'    => route('admin_variabel_setting', ['sort' => 'variabel', 'by' => 'asc', 'search' => '-']).'?page=1',
        'appbar_title' => $appbar_title,
        'sidebar'      => true,
        'roles'        => $roles
    ]) @endcomponent

    <div class="p-4 text-black" style="margin-bottom: 120px;">
        <h1 class='hidden'>Halaman {{ $appbar_title }} | Admin</h1>

        <div class="">
            <form action="{{ route('admin_variabel_store') }}" method="POST">
                @csrf()
                <input type="hidden" id="unique" name="unique" value="{{ $unique }}" readonly />
                <input  type="text" id="txt-variabel" name="variabel" required focused
                        placeholder="Variabel..." label="Variabel..."
                        class="w-full shadow-xl p-2 rounded-lg text-white"
                        style="background-color: rgba(0, 0, 0, 0.5)"
                />

                <input  type="text" id="txt-values" name="values" required focused
                        placeholder="Nilai..." label="Nilai..."
                        class="w-full mt-4 shadow-xl p-2 rounded-lg text-white"
                        style="background-color: rgba(0, 0, 0, 0.5)"
                />

                <div class="">
                    <button type="submit" class="mt-4 p-2 bg-blue-700 hover:bg-blue-500 shadow-xl text-white rounded-lg text-center w-full">
                        Simpan
                    </button>

                    <button type="button" class="mt-4 p-2 bg-pink-700 hover:bg-pink-500 shadow-xl text-white rounded-lg text-center w-full" onclick="window.location.href = `{{ route('admin_variabel_setting', ['sort' => 'variabel', 'by' => 'asc', 'search' => '-']).'?page=1' }}`">
                        Kembali
                    </button>
                </div>

                @if(session('error'))
                    <div class="bg-red-700 text-white text-center uppercase mt-4 rounded-lg p-4">
                        Terjadi Kesalahan! <br/>
                        Tidak dapat menyimpan data!
                    </div>
                @endif
            </form>
        </div>
    </div>

    @component('components.footer', ['hidden' => 'hidden', 'otherCSS' => '']) @endcomponent
@endsection