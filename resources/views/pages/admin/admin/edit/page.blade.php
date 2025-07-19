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
        'link_back'    => route('admin_anggota', ['sort' => 'name', 'by' => 'asc', 'search' => '-']).'?page=1',
        'appbar_title' => $appbar_title,
        'sidebar'      => true,
        'roles'        => $roles
    ]) @endcomponent

    <div class="p-4 text-black" style="margin-bottom: 0px;">
        <h1 class='hidden'>Halaman {{ $appbar_title }} | Admin</h1>

        <div class="">
            <form action="{{ route('admin_anggota_update', ['id'=>$id_data]) }}" method="POST">
                @method('PUT')
                @csrf()
                <input type="hidden" id="unique" name="unique" value="{{ $unique }}" readonly />
                
                <div class="">
                    <p><span class="font-bold">Nama :</span> {{ $data['nama'] }}</p>
                    <p><span class="font-bold">Email :</span> {{ $data['email'] }}</p>
                </div>

                <input  type="text" id="txt-no_identitas" name="no_identitas" required
                        placeholder="Nomor Identitas..." label="Nomor Identitas..."
                        class="mt-4 p-2 w-full block shadow-xl rounded-lg text-white"
                        style="background-color: rgba(0, 0, 0, 0.5)"
                        value="{{ $data['no_identitas'] }}"
                />
                <span class="font-bold italic text-red-700">* wajib</span>

                <div class="mt-4">
                    <span>Roles: </span>

                    <input type="radio" id="roles-su" name="roles" value="1" @if($data['roles'] == 1) checked @endif required />
                    <label for="roles-su">Super Admin</label>

                    <input type="radio" id="roles-ad" name="roles" value="2" @if($data['roles'] == 2) checked @endif required />
                    <label for="roles-ad">Admin</label>
                </div>
                <span class="font-bold italic text-red-700">* wajib</span>

                <div class="mt-4">
                    <span>Jenis Kelamin: </span>

                    <input type="radio" id="jk-p" name="jk" value="Pria" @if($data['jk'] == 'Pria') checked @endif required />
                    <label for="jk-p">Pria</label>

                    <input type="radio" id="jk-w" name="jk" value="Wanita" @if($data['jk'] == 'Wanita') checked @endif required />
                    <label for="jk-w">Wanita</label>
                </div>
                <span class="font-bold italic text-red-700">* wajib</span>

                <input  type="text" id="txt-status" name="status"
                        placeholder="Status Pernikahan..." label="Status Pernikahan..."
                        class="mt-4 p-2 w-full block shadow-xl rounded-lg text-white"
                        style="background-color: rgba(0, 0, 0, 0.5)"
                        value="{{ $data['status'] }}"
                />

                <input  type="text" id="txt-agama" name="agama"
                        placeholder="Agama..." label="Agama..."
                        class="mt-4 p-2 w-full block shadow-xl rounded-lg text-white"
                        style="background-color: rgba(0, 0, 0, 0.5)"
                        value="{{ $data['agama'] }}"
                />
                
                <textarea id="alamat" name="alamat"
                        class="mt-4 p-2 w-full block shadow-xl rounded-lg text-white"
                        style="background-color: rgba(0, 0, 0, 0.5)">{{ $data['alamat'] }}</textarea>

                <div class="">
                    <button type="submit" value="ok" class="mt-4 p-2 bg-blue-700 hover:bg-blue-500 shadow-xl text-white rounded-lg text-center w-full">
                        Simpan
                    </button>

                    <button type="button" class="mt-4 p-2 bg-pink-700 hover:bg-pink-500 shadow-xl text-white rounded-lg text-center w-full" onclick="window.location.href = `{{ route('admin_anggota', ['sort' => 'name', 'by' => 'asc', 'search' => '-']).'?page=1' }}`">
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