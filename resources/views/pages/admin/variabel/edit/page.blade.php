{{--
! Copyright @
! Syafiq
! Syahri Ramadhan Wiraasmara (ARI)
--}}
@extends('layouts.app')
@section('content')
    @component('components.appbarku', [
        'nama'         => $nama,
        'link_back'    => route('admin_variabel_setting', ['sort' => 'variabel', 'by' => 'asc', 'search' => '-']).'?page=1',
        'appbar_title' => $appbar_title,
    ]) @endcomponent

    <div class="p-4 text-black" style="margin-bottom: 120px;">
        <h1 class='hidden'>Halaman {{ $appbar_title }} | Admin</h1>

        <div class="">
            <form action="{{ route('admin_variabel_update', ['id' => $id]); }}" method="POST">
                @method('PUT')
                @csrf()
                <input type="hidden" id="unique" name="unique" value="{{ $unique }}" readonly />

                <input  type="text" id="txt-variabel" name="variabel" required focused
                        placeholder="Variabel..." label="Variabel..." value="{{ $data[0]['variabel']; }}"
                        class="w-full mt-4 border-white border-2 p-2 rounded-lg text-white"
                        style="background-color: rgba(0, 0, 0, 0.5)"
                />

                <input  type="text" id="txt-values" name="values" required focused
                        placeholder="Nilai..." label="Nilai..." value="{{ $data[0]['values']; }}"
                        class="w-full mt-4 border-white border-2 p-2 rounded-lg text-white"
                        style="background-color: rgba(0, 0, 0, 0.5)"
                />

                <div class="mt-4">
                    <button type="submit" class="p-2 bg-blue-700 hover:bg-blue-500 shadow-xl text-white rounded-lg text-center w-full">
                        Simpan
                    </button>

                    <button type="button" class="mt-4 p-2 bg-pink-700 hover:bg-pink-500 shadow-xl text-white rounded-lg text-center w-full" onclick="window.location.href = `{{ route('admin_variabel_setting', ['sort' => 'variabel', 'by' => 'asc', 'search' => '-']).'?page=1' }}`">
                        Kembali
                    </button>
                </div>
            </form>
        </div>
    </div>

    @component('components.footer', ['hidden' => 'hidden', 'otherCSS' => '']) @endcomponent
@endsection