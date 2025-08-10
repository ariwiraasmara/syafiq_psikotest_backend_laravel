@php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
@endphp
@extends('layouts.app')
@section('content')
    @component('components.homepage.header') @endcomponent
    @component('components.homepage.navbar', [
        'ispeserta' => $ispeserta,
        'path'      => $path,
        'domain'    => $domain
    ]) @endcomponent

    <div class="p-4 bg-kontak">
        <div class="p-4 bg-lp-white-glasses">
            <h2 class="text-2xl text-center font-bold">Kontak</h2>

            <p>Ayo bicara 👋 Jangan ragu untuk menghubungi melalui informasi kontak di bawah ini, atau kirimkan pesan menggunakan formulir.</p>

            <div class="mt-6 flex flex-row">
                <div class="basis-1/2">
                    <h3 class="text-2xl font-bold">Hubungi Kami</h3>

                    <p class="mt-2">
                        <span class="font-bold">Alamat: </span>
                        <a href="https://www.google.com/maps/search/Perum+Taman%20Mutiara%20Indah%20Blok%20B6%20No.%2017,%20RT.001/RW.016,Kelurahan%20Kaligandu,Kecamatan%20Serang,+City,+Kota%20Serang%20Banten,+42116+Indonesia" target="_blank" rel="noopener noreferrer" title="Buka Alamat di Google Maps">
                            Perum Taman Mutiara Indah Blok B6 No. 17, RT.001/RW.16 Kelurahan Kaligandu Kecamatan Kota Serang, Provinsi Banten, Indonesia 42116                            
                        </a>
                    </p>

                    <p class="mt-2">
                        <span class="font-bold">Email: </span><a href="mailto:lptsolusibanten@gmail.com">lptsolusibanten@gmail.com</a>
                    </p>

                    <p class="mt-2">
                        <span class="font-bold">Contact Person: </span><a href="wa.me/+6287777200782" target="_blank" title="Open in Whatsapp" rel="noopener, nofollow">+6287777200782</a> / <a href="wa.me/+6285311487755" target="_blank" title="Open in Whatsapp" rel="noopener, nofollow">+6285311487755</a>
                    </p>
                </div>
                <div class="basis-1/2">
                    <h3 class="text-2xl font-bold">Kirimkan Pesan Kepada Kami</h3>

                    <form action="" method="POST">
                        <div>
                            <span class="font-bold">Nama</span> <span class="bg-red-700 text-white italic">(*wajib)</span><br/>
                            <input  type="text" id="nama_klien" name="nama_klien" required
                                    class="w-full border-black border-2 p-2 rounded-lg text-black"
                            />
                        </div>

                        <div class="mt-4">
                            <span class="font-bold">Email</span> <span class="bg-red-700 text-white italic">(*wajib)</span><br/>
                            <input  type="email" id="email_klien" name="email_klien" required
                                    class="w-full border-black border-2 p-2 rounded-lg text-black"
                            />
                        </div>
                        
                        <div class="mt-4">
                            <span class="font-bold">No. Kontak</span> <span class="bg-red-700 text-white italic">(*wajib)</span><br/>
                            <input  type="number" id="kontak_klien" name="kontak_klien" required
                                    class="w-full border-black border-2 p-2 rounded-lg text-black"
                            />
                        </div>
                        
                        <div class="mt-4">
                            <span class="font-bold">Situs Web</span> <span class="italic">(optional)</span><br/>
                            <input  type="text" id="website_klien" name="website_klien"
                                    class="w-full border-black border-2 p-2 rounded-lg text-black"
                            />
                        </div>
                        
                        <div class="mt-4">
                            <span class="font-bold">Pesan</span> <span class="bg-red-700 text-white italic">(*wajib)</span><br/>
                            <textarea  id="pesan_klien" name="pesan_klien" required
                                    class="w-full border-black border-2 p-2 rounded-lg text-black">

                            </textarea>
                        </div>

                        <button type="submit" id="submit" name="submit" class="p-2 mt-4 w-full block bg-blue-700 hover:bg-blue-500 shadow-xl rounded-lg text-white text-center">
                            Kirim <ion-icon name="send-outline"></ion-icon>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @component('components.footer', ['hidden' => '', 'otherCSS' => '']) @endcomponent
@endsection
