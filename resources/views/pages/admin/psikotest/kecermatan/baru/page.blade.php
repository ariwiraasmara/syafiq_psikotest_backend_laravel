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
        'link_back'    => route('admin_psikotest_kecermatan'),
        'appbar_title' => $appbar_title,
        'sidebar'      => true,
        'roles'        => $roles
    ]) @endcomponent

    <div class="p-4 text-black" style="margin-bottom: 0px;">
        <h1 class='hidden'>Halaman {{ $appbar_title }} | Admin</h1>

        <div class="">
            <form action="{{ route('admin_psikotest_kecermatan_store') }}" method="POST">
                @csrf()
                <input type="hidden" id="unique" name="unique" value="{{ $unique }}" readonly />

                <div>
                    <input  type="text" id="kolom_x" name="kolom_x" required
                            placeholder="Kolom..." label="Kolom..."
                            class="w-full p-2 rounded-lg text-white shadow-xl"
                            style="background-color: rgba(0, 0, 0, 0.5)"
                    />
                    <input  type="number" id="nilai_A" name="nilai_A" required
                            placeholder="Nilai A..." label="Nilai A..."
                            class="w-full mt-4 p-2 rounded-lg text-white shadow-xl"
                            style="background-color: rgba(0, 0, 0, 0.5)"
                    />
                    <input  type="number" id="nilai_B" name="nilai_B" required
                            placeholder="Nilai B..." label="Nilai B..."
                            class="w-full mt-4 p-2 rounded-lg text-white shadow-xl"
                            style="background-color: rgba(0, 0, 0, 0.5)"
                    />
                    <input  type="number" id="nilai_C" name="nilai_C" required
                            placeholder="Nilai C..." label="Nilai C..."
                            class="w-full mt-4 p-2 rounded-lg text-white shadow-xl"
                            style="background-color: rgba(0, 0, 0, 0.5)"
                    />
                    <input  type="number" id="nilai_D" name="nilai_D" required
                            placeholder="Nilai D..." label="Nilai D..."
                            class="w-full mt-4 p-2 rounded-lg text-white shadow-xl"
                            style="background-color: rgba(0, 0, 0, 0.5)"
                    />
                    <input  type="number" id="nilai_E" name="nilai_E" required
                            placeholder="Nilai E..." label="Nilai E..."
                            class="w-full mt-4 p-2 rounded-lg text-white shadow-xl"
                            style="background-color: rgba(0, 0, 0, 0.5)"
                    />
                </div>

                <div class="">
                    <button type="submit" class="mt-4 p-2 bg-blue-700 hover:bg-blue-500 shadow-xl text-white rounded-lg text-center w-full">
                        Simpan
                    </button>

                    <button type="button" class="mt-4 p-2 bg-pink-700 hover:bg-pink-500 shadow-xl text-white rounded-lg text-center w-full" onclick="window.location.href = `{{ route('admin_psikotest_kecermatan') }}`">
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