@php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
@endphp
<footer class="p-2 bg-gradient-to-t from-sky-300 to-sky-500 {{ $hidden }} {{ $otherCSS }}">
    <div class="flex flex-col items-center justify-center text-center w-full mt-2 pb-2 border-b-2 border-black">
        <h2 class="font-bold text-lg hidden">Sitemap</h2>
        <div class="">
            <a href="{{ URL::temporarySignedRoute('home', now()->addMinutes(10)); }}" class="hover:underline" rel="follow" title="Beranda">
                Beranda
            </a>
            <span class="mx-2">▪</span>
            <a href="{{ URL::temporarySignedRoute('mengenai_kami', now()->addMinutes(10)); }}" class="hover:underline" rel="follow" title="Mengenai Kami">
                Mengenai Kami
            </a>
            <span class="mx-2">▪</span>
            <a href="{{ URL::temporarySignedRoute('layanan', now()->addMinutes(10)); }}" class="hover:underline" rel="follow" title="Layanan">
                Layanan
            </a>
            <span class="mx-2">▪</span>
            <a href="{{ URL::temporarySignedRoute('linkpsikotes', now()->addMinutes(10)); }}" class="hover:underline" rel="follow" title="Link Psikotes">
                Link Psikotes
            </a>
            <span class="mx-2">▪</span>
            <a href="{{ URL::temporarySignedRoute('kontak', now()->addMinutes(10)); }}" class="hover:underline" rel="follow" title="Kontak">
                Kontak
            </a>
            <span class="mx-2">▪</span>
            <a href="{{ route('blog').'?kategori=aktifitas' }}" class="hover:underline" rel="follow" title="Aktifitas">
                Aktifitas
            </a>
            <span class="mx-2">▪</span>
            <a href="{{ URL::temporarySignedRoute('artikel', now()->addMinutes(10)); }}" class="hover:underline" rel="follow" title="Artikel">
                Artikel
            </a>
            <span class="mx-2">▪</span>
            <a href="{{ URL::temporarySignedRoute('layanan_psikotessim', now()->addMinutes(10)); }}" class="hover:underline" rel="follow" title="Biro Psikotes SIM">
                Biro Psikotes SIM
            </a>
        </div>
    </div>
    <div class="mt-4 w-full text-xs items-center justify-items-center text-center">
        <h2 class="font-bold">Copyrights @</h2>
        <h3><strong>Syahri Ramadhan Wiraasmara</strong><br/>
            Programmer, Full Stack Developer<br/>
            ariwiraasmara.sc37@gmail.com<br/>
            +628176896353
        </h3>
        <h3 class="font-bold">Year {{ date('Y') }}. All Rights Reserved</h3>
    </div>
</footer>