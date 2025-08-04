{{--
! Copyright @
! PT. Solusi Psikologi Banten
! Syafiq Marzuki
! Syahri Ramadhan Wiraasmara (ARI)
--}}
<footer class="p-2 bg-gradient-to-t from-sky-300 to-sky-500 {{ $hidden }} {{ $otherCSS }}">
    <div class="justify-items-center items-center w-full mt-2 pb-2 border-b-2 border-black">
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
    <div class="mt-4 w-full text-xs">
        <h2 class="text-center font-bold underline">Copyright @ {{ date('Y') }} : </h2>
        <h3 class="text-center font-bold underline">PT. SOLUSI Psikologi Banten</h3>
        <h3 class="text-center font-bold underline">Psikotes Online App</h3>
        <div class="flex flex-row">
            <div class="basis-1/3 text-wrap">
                <h4 class='mt-2'>
                    <address>
                        <strong>Syafiq Marzuki</strong><br/>
                        Psikolog<br/>
                        +628511487755
                    </address>
                </h4>
            </div>
            <div class="basis-1/3 text-wrap ml-2">
                <h4 class='mt-2'>
                    <address>
                        <strong>Muhtar</strong><br/>
                        Marketing dan IT Support<br/>
                        +6287777200782
                    </address>
                </h4>
            </div>
            <div class="basis-1/3 text-wrap ml-2">
                <h4 class='mt-2'>
                    <address>
                        <strong>Syahri Ramadhan Wiraasmara</strong><br/>
                        Developer IT<br/>
                        ariwiraasmara.sc37@gmail.com<br/>
                        +628176896353
                    </address>
                </h4>
            </div>
        </div>
    </div>
</footer>